<?php

namespace App\Command;

use App\Domain\Package;
use App\Service\CostCalculator;
use App\Service\DeliveryScheduler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:calculate-courier',
    description: 'Calculate courier cost and delivery time'
)]
class CalculateCourierCommand extends Command
{
    public function __construct(
        private CostCalculator $costCalculator,
        private DeliveryScheduler $scheduler
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lines = file('input_delivery.txt', FILE_IGNORE_NEW_LINES);

        [$baseCost, $n] = array_map('intval', explode(' ', array_shift($lines)));

        $packages = [];
        for ($i = 0; $i < $n; $i++) {
            [$id, $w, $d, $code] = explode(' ', $lines[$i]);
            $packages[] = new Package($id, $w, $d, $code);
        }

        [$vehicles, $speed, $maxWeight] =
            array_map('intval', explode(' ', $lines[$n]));

        // Cost
        foreach ($packages as $pkg) {
            $this->costCalculator->calculate($pkg, $baseCost);
        }

        // Delivery
        $this->scheduler->schedule($packages, $vehicles, $speed, $maxWeight);

        // Output (PDF format)
        foreach ($packages as $pkg) {
            $output->writeln(sprintf(
                "%s %.0f %.0f %.2f",
                $pkg->id,
                $pkg->discount,
                $pkg->totalCost,
                round($pkg->deliveryTime, 2)
            ));
        }

        return Command::SUCCESS;
    }
}