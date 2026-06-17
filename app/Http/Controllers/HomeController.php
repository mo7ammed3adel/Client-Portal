<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'costPerKm' => Setting::getFloat('cost_per_km'),
            'baseFee' => Setting::getFloat('base_fee'),
            'baseDistanceKm' => Setting::getFloat('base_distance_km'),
        ]);
    }
}
