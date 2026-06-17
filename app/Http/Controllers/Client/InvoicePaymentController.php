<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\Kashier\KashierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoicePaymentController extends Controller
{
    public function store(Request $request, KashierService $kashierService): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'method' => ['nullable', 'in:card,wallet'],
        ]);

        $invoice = $request->user()->invoices()->create([
            'invoice_number' => 'PAY-'.now()->format('YmdHis').'-'.Str::upper(Str::random(5)),
            'amount' => round((float) $validated['amount'], 2),
            'due_date' => now()->toDateString(),
            'status' => 'pending',
        ]);

        $payment = $kashierService->createInvoicePayment($invoice, $validated['method'] ?? 'card');

        $invoice->forceFill([
            'kashier_merchant_order_id' => $payment['merchant_order_id'],
            'payment_method' => $payment['method'],
        ])->save();

        return redirect()->away($payment['payment_url']);
    }

    public function __invoke(Request $request, Invoice $invoice, KashierService $kashierService): RedirectResponse
    {
        abort_unless($invoice->client_id === $request->user()->id, 404);

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('client.billing.index')
                ->with('status', 'تم دفع هذه الفاتورة بالفعل.');
        }

        $validated = $request->validate([
            'method' => ['nullable', 'in:card,wallet'],
        ]);

        $payment = $kashierService->createInvoicePayment($invoice, $validated['method'] ?? 'card');

        $invoice->forceFill([
            'kashier_merchant_order_id' => $payment['merchant_order_id'],
            'payment_method' => $payment['method'],
        ])->save();

        return redirect()->away($payment['payment_url']);
    }
}
