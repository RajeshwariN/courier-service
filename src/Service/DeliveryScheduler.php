<?php

namespace App\Service;

use App\Domain\Package;

class DeliveryScheduler
{
    /**
     * @param Package[] $packages
     */
    public function schedule(
        array $packages,
        int $vehicleCount,
        int $speed,
        int $maxWeight
    ): void {
        $vehicleTimes = array_fill(0, $vehicleCount, 0.0);
        $remaining = $packages;

        while (!empty($remaining)) {

            // Earliest available vehicle
            asort($vehicleTimes);
            $vehicleIndex = array_key_first($vehicleTimes);
            $startTime = $vehicleTimes[$vehicleIndex];

            // 1️ Find BEST shipment
            $bestShipment = [];
            $bestCount = 0;
            $bestWeight = 0;
            $bestDistance = PHP_INT_MAX;

            $n = count($remaining);
            $limit = 1 << $n;

            // Generate all subsets
            for ($mask = 1; $mask < $limit; $mask++) {
                $weight = 0;
                $shipment = [];
                $maxDist = 0;

                for ($i = 0; $i < $n; $i++) {
                    if ($mask & (1 << $i)) {
                        $pkg = $remaining[$i];
                        $weight += $pkg->weight;
                        if ($weight > $maxWeight) continue 2;
                        $shipment[] = $pkg;
                        $maxDist = max($maxDist, $pkg->distance);
                    }
                }

                $count = count($shipment);

                if (
                    $count > $bestCount ||
                    ($count === $bestCount && $weight > $bestWeight) ||
                    ($count === $bestCount && $weight === $bestWeight && $maxDist < $bestDistance)
                ) {
                    $bestShipment = $shipment;
                    $bestCount = $count;
                    $bestWeight = $weight;
                    $bestDistance = $maxDist;
                }
            }

            // 2️ Assign delivery times
            foreach ($bestShipment as $pkg) {
                $pkg->deliveryTime = 
                    $startTime + ($pkg->distance / $speed);
            }

            // 3️ Vehicle returns
            $vehicleTimes[$vehicleIndex] =
                $startTime + (2 * $bestDistance) / $speed;

            // 4️ Remove delivered packages
            foreach ($bestShipment as $delivered) {
                $remaining = array_values(
                    array_filter(
                        $remaining,
                        fn($p) => $p !== $delivered
                    )
                );
            }
        }
    }
}