<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function __invoke(): View
    {
        return view('pricing', [
            'costPerKm' => Setting::getFloat('cost_per_km'),
            'baseFee' => Setting::getFloat('base_fee'),
            'minOrderCost' => Setting::getFloat('min_order_cost'),
        ]);
    }
}
