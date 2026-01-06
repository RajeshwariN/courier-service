<?php

namespace App\Domain;

class Package
{
    public float $discount = 0.0;
    public float $totalCost = 0.0;
    public float $deliveryTime = 0.0;

    public function __construct(
        public string $id,
        public int $weight,
        public int $distance,
        public string $offerCode
    ) {}
}
