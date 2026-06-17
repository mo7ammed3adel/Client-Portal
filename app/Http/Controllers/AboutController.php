<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('about', [
            'content' => Setting::allWithDefaults(),
        ]);
    }
}
