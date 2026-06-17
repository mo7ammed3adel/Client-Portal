<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => Setting::allWithDefaults(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cost_per_km' => ['required', 'numeric', 'min:0', 'max:100000'],
            'base_fee' => ['required', 'numeric', 'min:0', 'max:100000'],
            'base_distance_km' => ['required', 'numeric', 'min:0', 'max:1000'],
            'min_order_cost' => ['required', 'numeric', 'min:0', 'max:100000'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'string', 'max:255'],
            'contact_whatsapp' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_hours' => ['nullable', 'string', 'max:255'],
            'about_intro' => ['nullable', 'string', 'max:5000'],
            'about_vision' => ['nullable', 'string', 'max:5000'],
            'about_mission' => ['nullable', 'string', 'max:5000'],
            'about_terms' => ['nullable', 'string', 'max:10000'],
            'about_phone' => ['nullable', 'string', 'max:50'],
            'about_email' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::put($key, (string) $value);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'تم حفظ الإعدادات بنجاح.');
    }
}
