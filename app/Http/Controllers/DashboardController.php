<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        return $request->user()->isCourier()
            ? redirect()->route('courier.dashboard')
            : redirect()->route('admin.dashboard');
    }
}
