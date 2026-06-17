<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.kashier.mid' => 'MID-TEST',
            'services.kashier.payment_key' => 'test-payment-key',
            'services.kashier.secret_key' => 'test-secret',
            'services.kashier.checkout_url' => 'https://checkout.kashier.io',
            'app.url' => 'http://localhost',
        ]);
    }

    public function test_valid_order_is_created_as_pending_and_redirects_to_payment(): void
    {
        $response = $this->post(route('order.store'), $this->validPayload());

        $this->assertDatabaseCount('orders', 1);

        $order = Order::first();
        $this->assertSame('pending_payment', $order->status);
        $this->assertNull($order->order_number);
        $this->assertNull($order->paid_at);
        $this->assertNotNull($order->kashier_merchant_order_id);
        $this->assertGreaterThan(0, (float) $order->total_cost);

        $response->assertRedirect();
        $this->assertStringContainsString('checkout.kashier.io', $response->headers->get('Location'));
    }

    public function test_order_is_not_created_when_locations_are_missing(): void
    {
        $payload = $this->validPayload();
        unset($payload['pickup_lat'], $payload['pickup_lng']);

        $response = $this->from(route('order.create'))->post(route('order.store'), $payload);

        $response->assertSessionHasErrors(['pickup_lat', 'pickup_lng']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_successful_webhook_confirms_order_and_generates_tracking_number(): void
    {
        $order = Order::create([
            'status' => 'pending_payment',
            'sender_name' => 'Sender',
            'sender_phone' => '+201000000001',
            'receiver_name' => 'Receiver',
            'receiver_phone' => '+201000000002',
            'pickup_lat' => 30.0444,
            'pickup_lng' => 31.2357,
            'pickup_address' => 'A',
            'dropoff_lat' => 30.0131,
            'dropoff_lng' => 31.2089,
            'dropoff_address' => 'B',
            'distance_km' => 5.40,
            'cost_per_km' => 10,
            'base_fee' => 0,
            'total_cost' => 54.00,
        ]);

        $merchantOrderId = "order-{$order->id}-".\Illuminate\Support\Str::uuid();
        $order->forceFill(['kashier_merchant_order_id' => $merchantOrderId])->save();

        $payload = $this->signedWebhookPayload($merchantOrderId, '54.00');

        $response = $this->postJson(route('kashier.webhook'), $payload['body'], [
            'x-kashier-signature' => $payload['signature'],
        ]);

        $response->assertOk();

        $order->refresh();
        $this->assertSame('confirmed', $order->status);
        $this->assertNotNull($order->paid_at);
        $this->assertNotNull($order->order_number);
        $this->assertStringStartsWith('TLB-', $order->order_number);
    }

    public function test_webhook_rejects_amount_mismatch(): void
    {
        $order = Order::create([
            'status' => 'pending_payment',
            'sender_name' => 'S', 'sender_phone' => '1',
            'receiver_name' => 'R', 'receiver_phone' => '2',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 54.00,
        ]);
        $merchantOrderId = "order-{$order->id}-".\Illuminate\Support\Str::uuid();
        $order->forceFill(['kashier_merchant_order_id' => $merchantOrderId])->save();

        // Attacker reports a tiny amount.
        $payload = $this->signedWebhookPayload($merchantOrderId, '1.00');
        $this->postJson(route('kashier.webhook'), $payload['body'], [
            'x-kashier-signature' => $payload['signature'],
        ])->assertOk();

        $order->refresh();
        $this->assertSame('pending_payment', $order->status);
        $this->assertNull($order->paid_at);
    }

    public function test_success_page_shows_paid_order(): void
    {
        $order = Order::create([
            'status' => 'confirmed',
            'order_number' => 'TLB-260617-00099',
            'sender_name' => 'S', 'sender_phone' => '1',
            'receiver_name' => 'R', 'receiver_phone' => '2',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 50.00,
            'paid_at' => now(),
        ]);

        $this->get(route('order.success', $order->order_number))
            ->assertOk()
            ->assertSee('TLB-260617-00099');
    }

    public function test_tracking_finds_paid_order(): void
    {
        Order::create([
            'status' => 'out_for_delivery',
            'order_number' => 'TLB-260617-00077',
            'sender_name' => 'S', 'sender_phone' => '1',
            'receiver_name' => 'R', 'receiver_phone' => '2',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 50.00,
            'paid_at' => now(),
        ]);

        $this->get(route('order.track', ['number' => 'TLB-260617-00077']))
            ->assertOk()
            ->assertSee('في الطريق');
    }

    public function test_admin_can_view_and_update_a_paid_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::create([
            'status' => 'confirmed',
            'order_number' => 'TLB-260617-00055',
            'sender_name' => 'S', 'sender_phone' => '1',
            'receiver_name' => 'R', 'receiver_phone' => '2',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 50.00,
            'paid_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('TLB-260617-00055');

        $this->actingAs($admin)
            ->patch(route('admin.orders.update', $order), ['status' => 'out_for_delivery'])
            ->assertRedirect();

        $this->assertSame('out_for_delivery', $order->fresh()->status);
    }

    public function test_admin_cannot_open_unpaid_draft_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::create([
            'status' => 'pending_payment',
            'sender_name' => 'S', 'sender_phone' => '1',
            'receiver_name' => 'R', 'receiver_phone' => '2',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 50.00,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertNotFound();
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'sender_name' => 'أحمد',
            'sender_phone' => '+201000000001',
            'receiver_name' => 'سارة',
            'receiver_phone' => '+201000000002',
            'pickup_lat' => 30.0444,
            'pickup_lng' => 31.2357,
            'pickup_address' => 'وسط البلد',
            'dropoff_lat' => 30.0131,
            'dropoff_lng' => 31.2089,
            'dropoff_address' => 'المهندسين',
            'notes' => 'طرد صغير',
            'payment_method' => 'card',
        ];
    }

    /**
     * Build a webhook body with a signature that matches KashierService verification.
     *
     * @return array{body: array<string, mixed>, signature: string}
     */
    private function signedWebhookPayload(string $merchantOrderId, string $amount): array
    {
        $key = (string) config('services.kashier.payment_key');

        $pairs = [
            'amount' => $amount,
            'merchantOrderId' => $merchantOrderId,
            'status' => 'SUCCESS',
        ];
        ksort($pairs);

        $signature = hash_hmac('sha256', http_build_query($pairs), $key);

        return [
            'body' => [
                'event' => 'pay',
                'data' => [
                    'merchantOrderId' => $merchantOrderId,
                    'status' => 'SUCCESS',
                    'amount' => $amount,
                    'transactionId' => 'TX-TEST',
                    'kashierOrderId' => 'KO-TEST',
                    'method' => 'card',
                    'signatureKeys' => ['amount', 'merchantOrderId', 'status'],
                ],
            ],
            'signature' => $signature,
        ];
    }
}
