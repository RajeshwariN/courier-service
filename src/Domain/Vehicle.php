<?php

namespace App\Domain;

class Vehicle
{
    public float $availableAt = 0.0;

    public function __construct(
        public readonly float $maxWeight,
        public readonly float $speed
    ) {}
}