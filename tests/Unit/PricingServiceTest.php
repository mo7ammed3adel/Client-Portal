<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Services\Delivery\PricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_distance_between_identical_points_is_zero(): void
    {
        $service = new PricingService();

        $this->assertSame(0.0, $service->distanceKm(30.0, 31.0, 30.0, 31.0));
    }

    public function test_distance_is_positive_for_different_points(): void
    {
        $service = new PricingService();

        // Roughly the distance across central Cairo — should be a few km.
        $distance = $service->distanceKm(30.0444, 31.2357, 30.0131, 31.2089);

        $this->assertGreaterThan(3, $distance);
        $this->assertLessThan(6, $distance);
    }

    public function test_quote_uses_configured_cost_per_km(): void
    {
        Setting::put('cost_per_km', '10');
        Setting::put('base_fee', '0');
        Setting::put('min_order_cost', '0');

        $service = new PricingService();
        $quote = $service->quote(12.0);

        $this->assertSame(12.0, $quote['distance_km']);
        $this->assertSame(10.0, $quote['cost_per_km']);
        $this->assertSame(120.0, $quote['total_cost']);
    }

    public function test_quote_applies_base_fee_and_minimum(): void
    {
        Setting::put('cost_per_km', '10');
        Setting::put('base_fee', '15');
        Setting::put('min_order_cost', '200');

        $service = new PricingService();

        // 2km * 10 + 15 = 35, but minimum is 200.
        $this->assertSame(200.0, $service->quote(2.0)['total_cost']);

        // 30km * 10 + 15 = 315, above the minimum.
        $this->assertSame(315.0, $service->quote(30.0)['total_cost']);
    }
}
