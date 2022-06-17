<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerBalanceTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_fail_because_admin_cant_visualize_own_balance()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($user, ['*']);

        $this->json('GET', 'api/customer/balance')
             ->assertStatus(403);
    }

    public function test_must_visualize_my_own_balance()
    {
        $user = \Turnover\Models\User\User::factory()->create(['balance' => 200]);
        Sanctum::actingAs($user, ['*']);

        $this->json('GET', 'api/customer/balance')
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'balance'])
             ->assertJsonPath('balance', 200);
    }
}
