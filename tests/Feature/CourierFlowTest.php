<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierFlowTest extends TestCase
{
    use RefreshDatabase;

    private function paidOrder(array $overrides = []): Order
    {
        return Order::create(array_merge([
            'status' => 'confirmed',
            'order_number' => 'TLB-260617-00010',
            'sender_name' => 'مرسِل', 'sender_phone' => '+201000000001',
            'receiver_name' => 'مستلِم', 'receiver_phone' => '+201000000002',
            'pickup_lat' => 30.0, 'pickup_lng' => 31.0, 'pickup_address' => 'A',
            'dropoff_lat' => 30.1, 'dropoff_lng' => 31.1, 'dropoff_address' => 'B',
            'distance_km' => 5, 'cost_per_km' => 10, 'base_fee' => 0, 'total_cost' => 50.00,
            'paid_at' => now(),
            'pickup_otp' => '1234',
            'delivery_otp' => '5678',
        ], $overrides));
    }

    public function test_courier_role_redirects_to_courier_app(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);

        $this->actingAs($courier)
            ->get('/dashboard')
            ->assertRedirect(route('courier.dashboard', absolute: false));
    }

    public function test_admin_cannot_access_courier_app(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('courier.dashboard'))->assertForbidden();
    }

    public function test_courier_app_requires_authentication(): void
    {
        $this->get(route('courier.dashboard'))->assertRedirect(route('login', absolute: false));
    }

    public function test_courier_can_see_available_pickups(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);
        $this->paidOrder();

        $this->actingAs($courier)
            ->get(route('courier.dashboard'))
            ->assertOk()
            ->assertSee('TLB-260617-00010');
    }

    public function test_courier_can_open_order_and_see_pickup_form(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);
        $order = $this->paidOrder();

        $this->actingAs($courier)
            ->get(route('courier.orders.show', $order))
            ->assertOk()
            ->assertSee('تأكيد الاستلام');
    }

    public function test_courier_confirms_pickup_with_correct_otp(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);
        $order = $this->paidOrder();

        $this->actingAs($courier)
            ->post(route('courier.orders.pickup', $order), ['otp' => '1234'])
            ->assertRedirect(route('courier.orders.show', $order));

        $order->refresh();
        $this->assertSame('out_for_delivery', $order->status);
        $this->assertSame($courier->id, $order->courier_id);
        $this->assertNotNull($order->picked_up_at);
    }

    public function test_wrong_pickup_otp_is_rejected(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);
        $order = $this->paidOrder();

        $this->actingAs($courier)
            ->from(route('courier.orders.show', $order))
            ->post(route('courier.orders.pickup', $order), ['otp' => '0000'])
            ->assertSessionHasErrors('otp');

        $order->refresh();
        $this->assertSame('confirmed', $order->status);
        $this->assertNull($order->picked_up_at);
    }

    public function test_courier_confirms_delivery_with_correct_otp(): void
    {
        $courier = User::factory()->create(['role' => 'courier']);
        $order = $this->paidOrder([
            'status' => 'out_for_delivery',
            'courier_id' => null,
        ]);
        $order->forceFill(['courier_id' => $courier->id, 'picked_up_at' => now()])->save();

        $this->actingAs($courier)
            ->post(route('courier.orders.deliver', $order), ['otp' => '5678'])
            ->assertRedirect(route('courier.dashboard'));

        $order->refresh();
        $this->assertSame('delivered', $order->status);
        $this->assertNotNull($order->delivered_at);
    }

    public function test_courier_cannot_deliver_another_couriers_order(): void
    {
        $mine = User::factory()->create(['role' => 'courier']);
        $other = User::factory()->create(['role' => 'courier']);
        $order = $this->paidOrder(['status' => 'out_for_delivery']);
        $order->forceFill(['courier_id' => $other->id])->save();

        $this->actingAs($mine)
            ->post(route('courier.orders.deliver', $order), ['otp' => '5678'])
            ->assertNotFound();

        $this->assertSame('out_for_delivery', $order->fresh()->status);
    }

    public function test_admin_can_create_courier_and_assign_to_order(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = $this->paidOrder();

        $this->actingAs($admin)
            ->post(route('admin.couriers.store'), [
                'name' => 'كابتن جديد',
                'email' => 'new-captain@talba.eg',
                'phone' => '01099999999',
                'password' => 'secret123',
            ])
            ->assertRedirect(route('admin.couriers.index'));

        $courier = User::where('email', 'new-captain@talba.eg')->first();
        $this->assertNotNull($courier);
        $this->assertSame('courier', $courier->role);

        $this->actingAs($admin)
            ->patch(route('admin.orders.assign', $order), ['courier_id' => $courier->id])
            ->assertRedirect();

        $this->assertSame($courier->id, $order->fresh()->courier_id);
    }
}
