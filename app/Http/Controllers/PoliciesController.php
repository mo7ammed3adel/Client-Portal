<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class PoliciesController extends Controller
{
    public function __invoke(): View
    {
        return view('policies', [
            'content' => Setting::allWithDefaults(),
            'costPerKm' => Setting::getFloat('cost_per_km'),
            'baseFee' => Setting::getFloat('base_fee'),
            'baseDistanceKm' => Setting::getFloat('base_distance_km'),
        ]);
    }
}
