<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::query()
            ->with('client')
            ->latest()
            ->paginate(12);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $clients = User::query()
            ->where('role', 'client')
            ->orderBy('name')
            ->get();

        return view('admin.invoices.create', compact('clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'invoice_number' => ['required', 'string', 'max:255', 'unique:invoices,invoice_number'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:pending,paid,overdue'],
        ]);

        Invoice::create($validated);

        return redirect()
            ->route('admin.invoices.index')
            ->with('status', 'Invoice created.');
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,overdue'],
        ]);

        $invoice->update($validated);

        return back()->with('status', 'Invoice status updated.');
    }
}
