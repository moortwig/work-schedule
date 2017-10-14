<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApiRouteReturnsOk()
    {
        $response = $this->get('/api/shifts');

        $response->assertStatus(200);
    }
}
