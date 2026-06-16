<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $clients = User::query()
            ->where('role', 'client')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount(['tasks', 'invoices'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.clients.index', compact('clients', 'search'));
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'client',
        ]);

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client account created.');
    }

    public function edit(User $client): View
    {
        abort_unless($client->isClient(), 404);

        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($client)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $client->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (! empty($validated['password'])) {
            $client->password = Hash::make($validated['password']);
        }

        $client->save();

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client updated.');
    }

    public function destroy(User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client deleted.');
    }
}
