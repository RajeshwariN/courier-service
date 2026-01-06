<?php

namespace App\Domain\Offer;

use App\Domain\Package;

class OfferResolver
{
    /**
     * @param iterable<OfferInterface> $offers
     */
    public function __construct(
        private iterable $offers
    ) {}

    public function resolve(Package $package, float $deliveryCost): float
    {
        foreach ($this->offers as $offer) {
            if ($offer->supports($package->offerCode)) {
                return $offer->discount($deliveryCost, $package);
            }
        }

        // No offer / invalid offer code
        return 0.0;
    }
}
