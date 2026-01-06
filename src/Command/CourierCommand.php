<?php

namespace App\Command;

use App\Domain\Package;
use App\Service\CostCalculator;
use App\Service\DeliveryScheduler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:courier',
    description: 'Courier service cost and delivery estimation'
)]
class CourierCommand extends Command
{
    public function __construct(
        private CostCalculator $costCalculator,
        private DeliveryScheduler $deliveryScheduler
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = file('php://stdin', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!$lines) {
            $output->writeln('<error>No input provided</error>');
            return Command::FAILURE;
        }

        [$baseCost, $packageCount] = array_map('intval', explode(' ', array_shift($lines)));

        $packages = [];
        for ($i = 0; $i < $packageCount; $i++) {
            [$id, $w, $d, $o] = explode(' ', $lines[$i]);
            $packages[] = new Package($id, (int)$w, (int)$d, $o);
        }

        [$vehicles, $speed, $maxWeight] =
            array_map('intval', explode(' ', $lines[$packageCount]));

        $deliveryTimes = $this->deliveryScheduler
            ->calculate($packages, $vehicles, $speed, $maxWeight);

        foreach ($packages as $package) {
            $cost = $this->costCalculator->calculate($package);

            $output->writeln(sprintf(
                '%s %.2f %.2f %.2f',
                $package->id,
                $cost['discount'],
                $cost['total'],
                $deliveryTimes[$package->id]
            ));
        }

        return Command::SUCCESS;
    }
}