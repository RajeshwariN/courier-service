<?php

use PHPUnit\Framework\TestCase;
use App\Service\CostCalculator;
use App\Domain\Package;
use App\Domain\Offer\OfferResolver;

class CostCalculatorTest extends TestCase
{
    public function test_cost_without_offer()
    {
        $resolver = $this->createStub(OfferResolver::class);
        $resolver->method('resolve')->willReturn(0.0);

        $calculator = new CostCalculator($resolver);

        $pkg = new Package('PKG1', 5, 5, 'NA');
        $calculator->calculate($pkg, 100);

        $this->assertEquals(175, $pkg->totalCost);
        $this->assertEquals(0, $pkg->discount);
    }
}
