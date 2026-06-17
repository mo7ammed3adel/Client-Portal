<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CourierController extends Controller
{
    public function index(): View
    {
        $couriers = User::query()
            ->where('role', 'courier')
            ->withCount(['deliveries' => fn ($q) => $q->where('status', 'delivered')])
            ->latest()
            ->paginate(15);

        return view('admin.couriers.index', compact('couriers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'courier',
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.couriers.index')
            ->with('status', 'تم إنشاء حساب المندوب.');
    }

    public function destroy(User $courier): RedirectResponse
    {
        abort_unless($courier->isCourier(), 404);

        $courier->delete();

        return redirect()
            ->route('admin.couriers.index')
            ->with('status', 'تم حذف المندوب.');
    }
}
