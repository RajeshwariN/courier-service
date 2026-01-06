<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:calculate-cost',
    description: 'Problem 1: Calculate delivery cost with offers'
)]
class CalculateCostCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $baseCost = 100;

        $packages = [
            ['PKG1', 5, 5, 'OFR001'],
            ['PKG2', 15, 5, 'OFR002'],
            ['PKG3', 10, 100, 'OFR003'],
        ];

        foreach ($packages as [$id, $weight, $distance, $offer]) {
            $deliveryCost =
                $baseCost +
                ($weight * 10) +
                ($distance * 5);

            $discount = $this->calculateDiscount(
                $deliveryCost,
                $weight,
                $distance,
                $offer
            );

            $total = $deliveryCost - $discount;

            $output->writeln(
                "{$id} {$discount} {$total}"
            );
        }

        return Command::SUCCESS;
    }

    private function calculateDiscount(
        float $cost,
        float $weight,
        float $distance,
        string $offer
    ): float {
        return match ($offer) {
            'OFR001' =>
                ($distance >= 70 && $distance <= 200 &&
                 $weight >= 10 && $weight <= 150)
                    ? $cost * 0.10 : 0,

            'OFR002' =>
                ($distance >= 50 && $distance <= 150 &&
                 $weight >= 50 && $weight <= 250)
                    ? $cost * 0.07 : 0,

            'OFR003' =>
                ($distance >= 50 && $distance <= 250 &&
                $weight >= 10 && $weight <= 150)
                    ? $cost * 0.05 : 0,

            default => 0
        };
    }
}