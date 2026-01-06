<?php

namespace App\Domain\Offer;

use App\Domain\Package;

class OFR003 implements OfferInterface
{
    public function supports(string $code): bool
    {
        return $code === 'OFR003';
    }

    public function discount(float $cost, Package $p): float
    {
        return ($p->distance >= 50 && $p->distance <= 250 &&
                $p->weight >= 10 && $p->weight <= 150)
            ? $cost * 0.05
            : 0;
    }
}
