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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'reference' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('reference')) {
            $validated['image_path'] = $request->file('reference')->store('task-references', 'public');
        }

        $request->user()->tasks()->create($validated);

        return redirect()
            ->route('client.requests.index')
            ->with('status', 'Request submitted successfully.');
    }

    public function show(Request $request, MarketingTask $task): View
    {
        abort_unless($task->client_id === $request->user()->id, 403);

        return view('client.requests.show', compact('task'));
    }
}
