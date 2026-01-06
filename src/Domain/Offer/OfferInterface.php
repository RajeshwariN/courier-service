<?php

namespace App\Domain\Offer;

use App\Domain\Package;

interface OfferInterface
{
    public function supports(string $code): bool;
    public function discount(float $cost, Package $package): float;
}
