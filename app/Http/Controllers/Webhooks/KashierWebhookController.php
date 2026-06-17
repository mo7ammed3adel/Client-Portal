<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\Kashier\KashierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KashierWebhookController extends Controller
{
    public function __construct(
        private readonly KashierService $kashierService
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $signature = (string) $request->header('x-kashier-signature', '');
        $body = $request->json()->all();
        $data = is_array($body['data'] ?? null) ? $body['data'] : [];
        $event = strtolower((string) ($body['event'] ?? ''));

        if (! $this->kashierService->verifyWebhookSignature($data, $signature)) {
            Log::warning('kashier.webhook_signature_failed', [
                'transaction_id' => $data['transactionId'] ?? null,
                'event' => $event,
            ]);

            return response()->json(['success' => true]);
        }

        if (! in_array($event, ['pay', 'payment'], true)) {
            return response()->json(['success' => true]);
        }

        $this->recordPayment($this->normalize($data));

        return response()->json(['success' => true]);
    }

    public function returnRedirect(Request $request): RedirectResponse
    {
        $query = $request->query();
        $signatureOk = $this->kashierService->verifyRedirectSignature($query);
        $paid = strtoupper((string) ($query['paymentStatus'] ?? '')) === 'SUCCESS';

        if ($signatureOk && $paid) {
            $this->recordPayment($this->normalizeRedirect($query));
        }

        $merchantOrderId = (string) ($query['merchantOrderId'] ?? '');
        $status = $this->paymentRecorded($merchantOrderId) ? 'تم تسجيل الدفع بنجاح.' : 'لم يتم تأكيد الدفع حتى الآن.';

        return redirect()
            ->route('client.billing.index')
            ->with('status', $status);
    }

    /**
     * @param array<string, mixed> $payment
     */
    private function recordPayment(array $payment): void
    {
        $merchantOrderId = (string) ($payment['merchant_order_id'] ?? '');

        if (! preg_match('/^invoice-(\d+)-/', $merchantOrderId, $matches)) {
            return;
        }

        if (! (bool) ($payment['success'] ?? false)) {
            return;
        }

        $invoice = Invoice::query()
            ->whereKey((int) $matches[1])
            ->where('kashier_merchant_order_id', $merchantOrderId)
            ->first();

        if (! $invoice) {
            return;
        }

        $paidAmount = (float) ($payment['amount'] ?? 0);
        if (abs($paidAmount - (float) $invoice->amount) > 0.01) {
            Log::warning('kashier.amount_mismatch', [
                'invoice_id' => $invoice->id,
                'merchant_order_id' => $merchantOrderId,
                'invoice_amount' => (float) $invoice->amount,
                'paid_amount' => $paidAmount,
            ]);

            return;
        }

        if ($invoice->status === 'paid') {
            return;
        }

        $invoice->forceFill([
            'status' => 'paid',
            'kashier_order_id' => (string) ($payment['kashier_order_id'] ?? ''),
            'kashier_transaction_id' => (string) ($payment['transaction_id'] ?? ''),
            'payment_method' => (string) ($payment['method'] ?? $invoice->payment_method),
            'paid_at' => now(),
        ])->save();
    }

    private function paymentRecorded(string $merchantOrderId): bool
    {
        if ($merchantOrderId === '') {
            return false;
        }

        for ($attempt = 0; $attempt < 6; $attempt++) {
            if ($attempt > 0) {
                usleep(500_000);
            }

            if (Invoice::query()
                ->where('kashier_merchant_order_id', $merchantOrderId)
                ->where('status', 'paid')
                ->exists()) {
                return true;
            }
        }

        $payment = $this->kashierService->inquireTransaction($merchantOrderId);
        if ($payment) {
            $this->recordPayment($payment);

            return Invoice::query()
                ->where('kashier_merchant_order_id', $merchantOrderId)
                ->where('status', 'paid')
                ->exists();
        }

        return false;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function normalize(array $data): array
    {
        return [
            'merchant_order_id' => (string) ($data['merchantOrderId'] ?? ''),
            'kashier_order_id' => (string) ($data['kashierOrderId'] ?? ''),
            'transaction_id' => (string) ($data['transactionId'] ?? ''),
            'amount' => (float) ($data['amount'] ?? 0),
            'success' => strtoupper((string) ($data['status'] ?? '')) === 'SUCCESS',
            'method' => $data['method'] ?? null,
        ];
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    private function normalizeRedirect(array $query): array
    {
        return [
            'merchant_order_id' => (string) ($query['merchantOrderId'] ?? ''),
            'kashier_order_id' => (string) ($query['orderId'] ?? $query['kashierOrderId'] ?? ''),
            'transaction_id' => (string) ($query['transactionId'] ?? ''),
            'amount' => (float) ($query['amount'] ?? 0),
            'success' => strtoupper((string) ($query['paymentStatus'] ?? '')) === 'SUCCESS',
            'method' => $query['method'] ?? null,
        ];
    }
}
