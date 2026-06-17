<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible_without_login(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();
        $this->get(route('contact'))->assertOk();
        $this->get(route('order.create'))->assertOk();
        $this->get(route('order.track'))->assertOk();
    }

    public function test_dashboard_redirects_admin_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_admin_area_requires_authentication(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login', absolute: false));
        $this->get(route('admin.orders.index'))->assertRedirect(route('login', absolute: false));
    }

    public function test_non_admin_users_cannot_access_admin_area(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.orders.index'))->assertForbidden();
    }

    public function test_admin_can_access_management_screens(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.contacts.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.settings.edit'))->assertOk();
    }
}
