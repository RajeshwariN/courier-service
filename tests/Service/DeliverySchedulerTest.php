<?php

use PHPUnit\Framework\TestCase;
use App\Service\DeliveryScheduler;
use App\Domain\Package;

class DeliverySchedulerTest extends TestCase
{
    public function test_delivery_time_matches_sample()
    {
        $scheduler = new DeliveryScheduler();

        $packages = [
            new Package('PKG1', 50, 30, 'OFR001'),
            new Package('PKG2', 75, 125, 'NA'),
            new Package('PKG3', 175, 100, 'OFR003'),
            new Package('PKG4', 110, 60, 'OFR002'),
            new Package('PKG5', 155, 95, 'NA'),
        ];

        $scheduler->schedule($packages, 2, 70, 200);

        $this->assertSame(
            '1.43',
            number_format($packages[2]->deliveryTime, 2)
        );
    }
}
