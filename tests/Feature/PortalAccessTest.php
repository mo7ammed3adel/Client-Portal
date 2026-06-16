<?php

namespace Tests\Feature;

use App\Models\MarketingTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_client_are_redirected_to_their_dashboards(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect(route('admin.clients.index', absolute: false));

        $this->actingAs($client)
            ->get('/dashboard')
            ->assertRedirect(route('client.requests.index', absolute: false));
    }

    public function test_role_middleware_blocks_cross_portal_access(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $this->actingAs($admin)->get(route('client.requests.index'))->assertForbidden();
        $this->actingAs($client)->get(route('admin.clients.index'))->assertForbidden();
    }

    public function test_client_cannot_view_another_clients_request(): void
    {
        $owner = User::factory()->create(['role' => 'client']);
        $otherClient = User::factory()->create(['role' => 'client']);
        $task = MarketingTask::create([
            'client_id' => $owner->id,
            'title' => 'Private brief',
            'description' => 'Only the owning client can see this.',
            'status' => 'pending',
        ]);

        $this->actingAs($otherClient)
            ->get(route('client.requests.show', $task))
            ->assertForbidden();
    }
}
