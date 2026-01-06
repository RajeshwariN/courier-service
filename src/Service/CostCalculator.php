<?php

namespace App\Service;

use App\Domain\Package;
use App\Domain\Offer\OfferResolver;

class CostCalculator
{
    public function __construct(
        private OfferResolver $offerResolver
    ) {}

    public function calculate(Package $package, int $baseCost): void
    {
        $deliveryCost =
            $baseCost +
            ($package->weight * 10) +
            ($package->distance * 5);

        $discount = $this->offerResolver->resolve($package, $deliveryCost);

        $package->discount = round($discount, 2);
        $package->totalCost = round($deliveryCost - $discount, 2);
    }
}
