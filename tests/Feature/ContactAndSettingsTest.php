<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_submit_contact_request(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'محمد',
            'email' => 'mohamed@example.com',
            'phone' => '+201234567890',
            'message' => 'أريد الاستفسار عن أسعار الشحن.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'mohamed@example.com',
            'status' => 'new',
        ]);
    }

    public function test_contact_request_requires_all_fields(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.store'), ['name' => 'x'])
            ->assertSessionHasErrors(['email', 'phone', 'message']);

        $this->assertDatabaseCount('contact_requests', 0);
    }

    public function test_admin_can_update_pricing_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->patch(route('admin.settings.update'), [
                'cost_per_km' => '15',
                'base_fee' => '5',
                'base_distance_km' => '2',
                'min_order_cost' => '0',
            ])
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertSame('15', Setting::get('cost_per_km'));
        $this->assertSame(15.0, Setting::getFloat('cost_per_km'));

        // The new rate appears on the public order page.
        $this->get(route('order.create'))->assertSee('data-cost-per-km="15"', false);
    }

    public function test_admin_can_review_contact_request(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contact = ContactRequest::create([
            'name' => 'عميل',
            'email' => 'lead@example.com',
            'phone' => '+201000000000',
            'message' => 'استفسار',
            'status' => 'new',
        ]);

        // Viewing a new request marks it reviewed.
        $this->actingAs($admin)->get(route('admin.contacts.show', $contact))->assertOk();
        $this->assertSame('reviewed', $contact->fresh()->status);
    }
}
