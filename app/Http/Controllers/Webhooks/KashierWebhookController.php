<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $merchantOrderId = (string) ($query['merchantOrderId'] ?? '');

        if ($signatureOk && $paid) {
            $this->recordPayment($this->normalizeRedirect($query));
        }

        $order = $this->resolveOrder($merchantOrderId);

        if ($order && $order->isPaid()) {
            return redirect()->route('order.success', $order->order_number);
        }

        // Give the webhook a moment / inquire before declaring failure.
        if ($order && $this->paymentRecorded($merchantOrderId)) {
            return redirect()->route('order.success', $order->fresh()->order_number);
        }

        return redirect()->route('order.failed', ['order' => $order?->id]);
    }

    /**
     * @param array<string, mixed> $payment
     */
    private function recordPayment(array $payment): void
    {
        $merchantOrderId = (string) ($payment['merchant_order_id'] ?? '');

        $order = $this->resolveOrder($merchantOrderId);

        if (! $order) {
            return;
        }

        if (! (bool) ($payment['success'] ?? false)) {
            return;
        }

        $paidAmount = (float) ($payment['amount'] ?? 0);
        if (abs($paidAmount - (float) $order->total_cost) > 0.01) {
            Log::warning('kashier.amount_mismatch', [
                'order_id' => $order->id,
                'merchant_order_id' => $merchantOrderId,
                'order_amount' => (float) $order->total_cost,
                'paid_amount' => $paidAmount,
            ]);

            return;
        }

        if ($order->isPaid()) {
            return;
        }

        $order->forceFill([
            'status' => 'confirmed',
            'order_number' => $order->order_number ?: $this->generateOrderNumber($order),
            'kashier_order_id' => (string) ($payment['kashier_order_id'] ?? ''),
            'kashier_transaction_id' => (string) ($payment['transaction_id'] ?? ''),
            'payment_method' => (string) ($payment['method'] ?? $order->payment_method),
            'paid_at' => now(),
        ])->save();
    }

    private function resolveOrder(string $merchantOrderId): ?Order
    {
        if (! preg_match('/^order-(\d+)-/', $merchantOrderId, $matches)) {
            return null;
        }

        return Order::query()
            ->whereKey((int) $matches[1])
            ->where('kashier_merchant_order_id', $merchantOrderId)
            ->first();
    }

    private function generateOrderNumber(Order $order): string
    {
        return 'TLB-'.now()->format('ymd').'-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);
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

            if ($this->orderPaid($merchantOrderId)) {
                return true;
            }
        }

        $payment = $this->kashierService->inquireTransaction($merchantOrderId);
        if ($payment) {
            $payment['merchant_order_id'] = $merchantOrderId;
            $this->recordPayment($payment);

            return $this->orderPaid($merchantOrderId);
        }

        return false;
    }

    private function orderPaid(string $merchantOrderId): bool
    {
        return Order::query()
            ->where('kashier_merchant_order_id', $merchantOrderId)
            ->whereNotNull('paid_at')
            ->exists();
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
