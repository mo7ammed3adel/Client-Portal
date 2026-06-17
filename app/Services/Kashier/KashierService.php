<?php

namespace App\Services\Kashier;

use App\Exceptions\Business\KashierApiException;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KashierService
{
    private string $mid;
    private string $paymentKey;
    private string $secretKey;
    private string $mode;
    private string $currency;
    private string $checkoutUrl;
    private string $apiBaseUrl;
    private string $allowedMethods;
    private int $timeout;

    public function __construct()
    {
        $this->mid = (string) config('services.kashier.mid');
        $this->paymentKey = (string) config('services.kashier.payment_key');
        $this->secretKey = (string) config('services.kashier.secret_key');
        $this->mode = (string) config('services.kashier.mode', 'test');
        $this->currency = (string) config('services.kashier.currency', 'EGP');
        $this->checkoutUrl = rtrim((string) config('services.kashier.checkout_url', 'https://checkout.kashier.io'), '/');
        $this->apiBaseUrl = rtrim((string) config('services.kashier.api_base_url', 'https://test-fep.kashier.io'), '/');
        $this->allowedMethods = (string) config('services.kashier.allowed_methods', 'card,wallet');
        $this->timeout = (int) config('services.kashier.timeout', 20);
    }

    public function createOrderPayment(Order $order, string $method = 'card'): array
    {
        $merchantOrderId = "order-{$order->id}-".(string) Str::uuid();

        return $this->buildHostedPayment($merchantOrderId, (float) $order->total_cost, $method);
    }

    public function verifyWebhookSignature(array $data, string $receivedSignature): bool
    {
        $keys = $data['signatureKeys'] ?? [];

        return $this->signatureMatches($data, is_array($keys) ? $keys : [], $receivedSignature);
    }

    public function verifyRedirectSignature(array $query): bool
    {
        $received = (string) ($query['signature'] ?? '');
        if ($received === '') {
            return false;
        }

        $sets = [];
        $allExcept = $query;
        unset($allExcept['signature'], $allExcept['mode']);
        if ($allExcept !== []) {
            $sets[] = $allExcept;
        }

        if (! empty($query['signatureKeys'])) {
            $keys = is_array($query['signatureKeys'])
                ? $query['signatureKeys']
                : array_filter(array_map('trim', explode(',', (string) $query['signatureKeys'])));
            $subset = [];

            foreach ($keys as $key) {
                if (array_key_exists($key, $query)) {
                    $subset[$key] = $query[$key];
                }
            }

            if ($subset !== []) {
                $sets[] = $subset;
            }
        }

        foreach ($sets as $set) {
            if ($this->redirectFieldSetMatches($set, $received)) {
                return true;
            }
        }

        return false;
    }

    public function inquireTransaction(string $merchantOrderId): ?array
    {
        if ($merchantOrderId === '') {
            return null;
        }

        try {
            $response = Http::baseUrl($this->apiBaseUrl)
                ->timeout($this->timeout)
                ->withHeaders(['Authorization' => $this->secretKey])
                ->acceptJson()
                ->get("/orders/{$merchantOrderId}");
        } catch (\Throwable $e) {
            Log::warning('kashier.inquiry.error', [
                'merchant_order_id' => $merchantOrderId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        $body = $response->json();
        if (! is_array($body)) {
            return null;
        }

        $status = strtoupper((string) ($body['status'] ?? data_get($body, 'response.status', '')));
        if (! in_array($status, ['SUCCESS', 'PAID'], true)) {
            return null;
        }

        return [
            'merchant_order_id' => $merchantOrderId,
            'kashier_order_id' => (string) ($body['kashierOrderId'] ?? data_get($body, 'response.kashierOrderId', '')),
            'transaction_id' => (string) ($body['transactionId'] ?? data_get($body, 'response.transactionId', '')),
            'amount' => (float) ($body['amount'] ?? data_get($body, 'response.amount', 0)),
            'success' => true,
            'method' => $body['method'] ?? data_get($body, 'response.method'),
        ];
    }

    private function buildHostedPayment(string $merchantOrderId, float $amount, string $method): array
    {
        $this->assertConfigured();

        $amountStr = number_format($amount, 2, '.', '');
        $appUrl = rtrim((string) config('app.url'), '/');

        $params = [
            'merchantId' => $this->mid,
            'orderId' => $merchantOrderId,
            'amount' => $amountStr,
            'currency' => $this->currency,
            'hash' => $this->paymentHash($merchantOrderId, $amountStr),
            'mode' => $this->mode,
            'merchantRedirect' => $appUrl.route('kashier.return', [], false),
            'serverWebhook' => $appUrl.route('kashier.webhook', [], false),
            'allowedMethods' => $method === 'wallet' ? 'wallet' : ($method === 'card' ? 'card' : $this->allowedMethods),
            'display' => 'ar',
        ];

        $paymentUrl = $this->checkoutUrl.'/?'.http_build_query($params);

        Log::info('kashier.call', [
            'endpoint' => 'buildHostedPayment',
            'merchant_order_id' => $merchantOrderId,
            'amount' => $amountStr,
            'method' => $method,
            'mode' => $this->mode,
        ]);

        return [
            'method' => $method === 'wallet' ? 'wallet' : 'card',
            'payment_url' => $paymentUrl,
            'redirect_url' => $paymentUrl,
            'merchant_order_id' => $merchantOrderId,
        ];
    }

    private function paymentHash(string $merchantOrderId, string $amount): string
    {
        $path = "/?payment={$this->mid}.{$merchantOrderId}.{$amount}.{$this->currency}";

        return hash_hmac('sha256', $path, $this->paymentKey);
    }

    private function redirectFieldSetMatches(array $fields, string $received): bool
    {
        $sorted = $fields;
        ksort($sorted);

        foreach ([$fields, $sorted] as $ordered) {
            $candidates = [
                implode('&', array_map(
                    fn ($key, $value) => "{$key}={$this->stringifyValue($value)}",
                    array_keys($ordered),
                    array_values($ordered)
                )),
                http_build_query($ordered, '', '&', PHP_QUERY_RFC3986),
                http_build_query($ordered),
            ];

            foreach ($candidates as $queryString) {
                if (hash_equals(hash_hmac('sha256', $queryString, $this->paymentKey), $received)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function signatureMatches(array $source, array $keys, string $received): bool
    {
        if ($keys === [] || $received === '') {
            return false;
        }

        $sorted = $keys;
        sort($sorted);

        foreach ([$sorted, $keys] as $order) {
            $pairs = [];

            foreach ($order as $key) {
                if (array_key_exists($key, $source)) {
                    $pairs[$key] = $this->stringifyValue($source[$key]);
                }
            }

            $candidates = [
                http_build_query($pairs, '', '&', PHP_QUERY_RFC3986),
                http_build_query($pairs),
                implode('&', array_map(
                    static fn ($key, $value) => "{$key}={$value}",
                    array_keys($pairs),
                    array_values($pairs)
                )),
            ];

            foreach ($candidates as $queryString) {
                if (hash_equals(hash_hmac('sha256', $queryString, $this->paymentKey), $received)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function stringifyValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string) $value;
    }

    private function assertConfigured(): void
    {
        $missing = [];
        if ($this->mid === '') {
            $missing[] = 'KASHIER_MID';
        }
        if ($this->paymentKey === '') {
            $missing[] = 'KASHIER_PAYMENT_KEY';
        }

        if ($missing === []) {
            return;
        }

        Log::warning('kashier.config.invalid', ['missing' => $missing]);

        throw new KashierApiException(
            'إعدادات كاشير الناقصة: '.implode(', ', $missing),
            'إعدادات الدفع من كاشير غير مكتملة.'
        );
    }
}
