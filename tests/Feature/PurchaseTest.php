<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class PurchaseTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_enter_with_amount_and_description()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->json('POST', 'api/purchases')
             ->assertStatus(422)
             ->assertJson([
                 'message' => 'The amount field is required. (and 1 more error)',
                 'errors'  => [
                     'amount'      => ['The amount field is required.'],
                     'description' => ['The description field is required.'],
                 ]
             ]);
    }

    public function test_must_fail_because_admin_cant_purchase()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $data = [
            'amount'      => 100.00,
            'description' => 'First purchase'
        ];

        $this->json('POST', 'api/purchases', $data)
             ->assertStatus(403)
             ->assertJsonPath('success', false)
             ->assertJsonPath('message', __('errors.youre_not_customer'));
    }

    public function test_must_fail_because_customer_dont_have_enough_money()
    {
        $user = \Turnover\Models\User\User::factory()->create(['balance' => 50.00]);
        Sanctum::actingAs($user, ['*']);

        $data = [
            'amount'      => 100.00,
            'description' => 'First purchase'
        ];

        $this->json('POST', 'api/purchases', $data)
             ->assertStatus(422)
             ->assertJson([
                 'message' => __('errors.enough_money'),
                 'errors'  => [
                     'amount' => [__('errors.enough_money')]
                 ]
             ]);
    }

    public function test_must_successful_purchase_and_adjust_customer_transaction()
    {
        $user = \Turnover\Models\User\User::factory()->create(['balance' => 50.00]);
        Sanctum::actingAs($user, ['*']);

        $data = [
            'amount'      => 39.80,
            'description' => 'First purchase'
        ];

        $this->json('POST', 'api/purchases', $data)
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'transaction'])
             ->assertJsonPath('transaction.status_id', TransactionStatus::ACCEPTED)
             ->assertJsonPath('transaction.type_id', TransactionType::PURCHASE)
             ->assertJsonPath('transaction.customer_id', $user->id);

        $user2 = \Turnover\Models\User\User::find($user->id);

        $this->assertEquals(10.20, $user2->balance);
    }
}
