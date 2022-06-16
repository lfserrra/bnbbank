<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class AcceptDepositTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_fail_because_only_admin_can_accept_deposits()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::PENDING,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/accept")
             ->assertStatus(403);
    }

    public function test_must_fail_because_transaction_to_accept_was_not_found()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $this->json('POST', "api/deposit/1000/accept")
             ->assertStatus(404)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_not_found'));
    }

    public function test_must_fail_because_transaction_to_accept_was_previously_accepted()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::ACCEPTED,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/accept")
             ->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_previously_accepted'));
    }

    public function test_must_fail_because_transaction_to_accept_was_previously_rejected()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::REJECTED,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/accept")
             ->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_previously_rejected'));
    }

    public function test_must_successful_accept_transaction()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::PENDING,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $customer_balance = $transaction->customer->balance;

        $this->json('POST', "api/deposit/$transaction->id/accept")
             ->assertStatus(200)
             ->assertJsonPath('success', true);

        $transaction2 = \Turnover\Models\Transaction\Transaction::find($transaction->id);

        $this->assertEquals($customer_balance + $transaction->amount, $transaction2->customer->balance);
        $this->assertEquals(TransactionStatus::ACCEPTED, $transaction2->status_id);
    }

    public function test_must_fail_because_only_admin_can_reject_deposits()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::PENDING,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/reject")
             ->assertStatus(403);
    }

    public function test_must_fail_because_transaction_to_reject_was_not_found()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $this->json('POST', "api/deposit/1000/reject")
             ->assertStatus(404)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_not_found'));
    }

    public function test_must_fail_because_transaction_to_reject_was_previously_accepted()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::ACCEPTED,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/reject")
             ->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_previously_accepted'));
    }

    public function test_must_fail_because_transaction_to_reject_was_previously_rejected()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::REJECTED,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $this->json('POST', "api/deposit/$transaction->id/reject")
             ->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonStructure(['success', 'message'])
             ->assertJsonPath('message', __('errors.transaction_previously_rejected'));
    }

    public function test_must_successful_reject_transaction()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::factory()->create([
            'status_id' => TransactionStatus::PENDING,
            'type_id'   => TransactionType::DEPOSIT
        ]);

        $customer_balance = $transaction->customer->balance;

        $this->json('POST', "api/deposit/$transaction->id/reject")
             ->assertStatus(200)
             ->assertJsonPath('success', true);

        $transaction2 = \Turnover\Models\Transaction\Transaction::find($transaction->id);

        $this->assertEquals($customer_balance, $transaction2->customer->balance);
        $this->assertEquals(TransactionStatus::REJECTED, $transaction2->status_id);
    }
}
