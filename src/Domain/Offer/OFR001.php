<?php

namespace App\Domain\Offer;

use App\Domain\Package;

class OFR001 implements OfferInterface
{
    public function supports(string $code): bool
    {
        return $code === 'OFR001';
    }

    public function discount(float $cost, Package $p): float
    {
        return ($p->distance >= 70 && $p->distance <= 200 &&
                $p->weight >= 10 && $p->weight <= 150)
            ? $cost * 0.10
            : 0.0;
    }
}
