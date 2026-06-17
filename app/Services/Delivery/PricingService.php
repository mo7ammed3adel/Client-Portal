<?php

namespace App\Services\Delivery;

use App\Models\Setting;

class PricingService
{
    private const EARTH_RADIUS_KM = 6371.0;

    /**
     * Great-circle (Haversine) distance between two coordinates in kilometres,
     * rounded to two decimals. This is the authoritative server-side value used
     * for pricing — the client estimate is for display only.
     */
    public function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(self::EARTH_RADIUS_KM * $c, 2);
    }

    /**
     * Build a full price quote for a pair of coordinates using the current
     * (admin-configurable) pricing settings.
     *
     * @return array{distance_km: float, cost_per_km: float, base_fee: float, total_cost: float}
     */
    public function quoteForCoordinates(float $lat1, float $lng1, float $lat2, float $lng2): array
    {
        return $this->quote($this->distanceKm($lat1, $lng1, $lat2, $lng2));
    }

    /**
     * Build a price quote from a known distance.
     *
     * Pricing model: the base fee covers the first `base_distance_km`
     * kilometres; every kilometre beyond that costs `cost_per_km`.
     * Example: 20 EGP for the first 2 km, then 10 EGP per extra km.
     *
     * @return array{distance_km: float, cost_per_km: float, base_fee: float, base_distance_km: float, total_cost: float}
     */
    public function quote(float $distanceKm): array
    {
        $costPerKm = Setting::getFloat('cost_per_km');
        $baseFee = Setting::getFloat('base_fee');
        $baseDistance = Setting::getFloat('base_distance_km');
        $minCost = Setting::getFloat('min_order_cost');

        $extraKm = max(0.0, $distanceKm - $baseDistance);
        $total = $baseFee + ($extraKm * $costPerKm);
        $total = max($total, $minCost);

        return [
            'distance_km' => round($distanceKm, 2),
            'cost_per_km' => round($costPerKm, 2),
            'base_fee' => round($baseFee, 2),
            'base_distance_km' => round($baseDistance, 2),
            'total_cost' => round($total, 2),
        ];
    }
}
