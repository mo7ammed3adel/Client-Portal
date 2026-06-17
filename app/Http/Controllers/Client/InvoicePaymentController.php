<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\Kashier\KashierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    public function __invoke(Request $request, Invoice $invoice, KashierService $kashierService): RedirectResponse
    {
        abort_unless($invoice->client_id === $request->user()->id, 404);

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('client.billing.index')
                ->with('status', 'Invoice is already paid.');
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
