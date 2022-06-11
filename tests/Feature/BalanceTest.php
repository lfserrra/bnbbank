<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\BalanceCheck\BalanceCheck;

class BalanceTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_enter_amount_description_and_check()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->json('POST', 'api/balances')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The amount field is required. (and 2 more errors)',
                 'errors'  => [
                     'amount'      => ['The amount field is required.'],
                     'description' => ['The description field is required.'],
                     'check'       => ['The check field is required.'],
                 ]
             ]);
    }

    public function test_successful_create_balance()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Storage::fake('local');
        $file = UploadedFile::fake()->image('check.jpg');

        $data = [
            'amount'      => 50.99,
            'description' => 'First deposit',
            'check'       => $file
        ];

        $result = $this->json('POST', 'api/balances', $data)
                       ->assertStatus(200)
                       ->assertJsonPath('success', true)
                       ->assertJsonStructure(['success', 'balance'])
                       ->assertJsonPath('balance.status_id', 1)
                       ->assertJsonPath('balance.type_id', 1)
                       ->assertJsonPath('balance.customer_id', $user->id);

        $balance_id    = $result['balance']['id'];
        $balance_check = BalanceCheck::where('balance_id', $balance_id)->first();

        Storage::disk('local')->assertExists($balance_check->url);
    }
}
