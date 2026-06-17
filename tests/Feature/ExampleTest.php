<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The public landing page is reachable by anyone.
     */
    public function test_home_page_loads_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('طلبة');
    }
}
