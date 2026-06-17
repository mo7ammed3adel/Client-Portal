<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $tasks = MarketingTask::query()
            ->with('client')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.requests.index', compact('tasks', 'status'));
    }

    public function update(Request $request, MarketingTask $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,completed'],
        ]);

        $task->update($validated);

        return back()->with('status', 'تم تحديث حالة الطلب.');
    }
}
