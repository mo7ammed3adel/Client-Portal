<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact', [
            'content' => Setting::allWithDefaults(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactRequest::create($validated + ['status' => 'new']);

        return redirect()
            ->route('contact')
            ->with('status', 'تم استلام رسالتك بنجاح. سيتواصل معك فريق الدعم في أقرب وقت.');
    }
}
