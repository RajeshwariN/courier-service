<?php

namespace App\Domain\Offer;

use App\Domain\Package;

class OFR002 implements OfferInterface
{
    public function supports(string $code): bool
    {
        return $code === 'OFR002';
    }

    public function discount(float $cost, Package $p): float
    {
        return ($p->distance >= 50 && $p->distance <= 150 &&
                $p->weight >= 50 && $p->weight <= 250)
            ? $cost * 0.07
            : 0;
    }
}
