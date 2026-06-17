<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MarketingTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->paginate(10);

        return view('client.requests.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('client.requests.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'delivery_latitude' => ['required', 'numeric', 'between:-90,90'],
            'delivery_longitude' => ['required', 'numeric', 'between:-180,180'],
            'address_details' => ['required', 'string', 'max:5000'],
        ]);

        $validated['title'] = 'Delivery order';
        $validated['description'] = $validated['address_details'];

        $request->user()->tasks()->create($validated);

        return redirect()
            ->route('client.requests.index')
            ->with('status', 'Delivery order submitted successfully.');
    }

    public function show(Request $request, MarketingTask $task): View
    {
        abort_unless($task->client_id === $request->user()->id, 403);

        return view('client.requests.show', compact('task'));
    }
}
