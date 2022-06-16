<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class TransactionTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_visualize_my_transaction()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::create([
            'status_id'   => TransactionStatus::ACCEPTED,
            'type_id'     => TransactionType::PURCHASE,
            'customer_id' => $user->id,
            'amount'      => -50.99,
            'description' => 'First order',
        ]);

        $this->json('GET', 'api/transactions/' . $transaction->id)
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'transaction'])
             ->assertJsonPath('transaction.status_id', TransactionStatus::ACCEPTED)
             ->assertJsonPath('transaction.type_id', TransactionType::PURCHASE)
             ->assertJsonPath('transaction.customer_id', $user->id);
    }

    public function test_must_fail_when_visualize_transaction_of_another_customer()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::create([
            'status_id'   => TransactionStatus::ACCEPTED,
            'type_id'     => TransactionType::PURCHASE,
            'customer_id' => 3,
            'amount'      => 100.99,
            'description' => 'First deposit',
        ]);

        $this->json('GET', 'api/transactions/' . $transaction->id)
             ->assertStatus(403);
    }

    public function test_must_admin_visualize_a_transaction()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($user, ['*']);

        $transaction = Transaction::create([
            'status_id'   => TransactionStatus::ACCEPTED,
            'type_id'     => TransactionType::PURCHASE,
            'customer_id' => 2,
            'amount'      => 100.99,
            'description' => 'First deposit',
        ]);

        $this->json('GET', 'api/transactions/' . $transaction->id)
             ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'transaction'])
            ->assertJsonPath('transaction.status_id', TransactionStatus::ACCEPTED)
            ->assertJsonPath('transaction.type_id', TransactionType::PURCHASE)
            ->assertJsonPath('transaction.customer_id', 2);
    }

    public function test_must_visualize_my_transactions_list()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        \Turnover\Models\Transaction\Transaction::factory(2)->create(['type_id' => TransactionType::DEPOSIT, 'customer_id' => $user->id]);
        \Turnover\Models\Transaction\Transaction::factory(3)->create(['type_id' => TransactionType::PURCHASE, 'customer_id' => $user->id]);

        //No filters
        $this->json('GET', 'api/transactions')
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'data'])
             ->assertJsonCount(5, 'data')
             ->assertJsonPath('data.0.customer_id', $user->id);
    }

    public function test_must_visualize_my_transactions_list_with_filtered_types()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $types = [TransactionType::DEPOSIT => 2, TransactionType::PURCHASE => 3];

        foreach ($types as $type => $number) {
            \Turnover\Models\Transaction\Transaction::factory($number)->create([
                'type_id'     => $type,
                'customer_id' => $user->id
            ]);
        }

        foreach ($types as $type => $number) {
            $this->json('GET', 'api/transactions', ['type_id' => $type])
                 ->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['success', 'data'])
                 ->assertJsonCount($number, 'data')
                 ->assertJsonPath('data.0.customer_id', $user->id)
                 ->assertJsonPath('data.0.type_id', $type);
        }
    }

    public function test_must_visualize_my_transactions_list_with_filtered_status()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $status = [TransactionStatus::PENDING => 2, TransactionStatus::ACCEPTED => 3, TransactionStatus::REJECTED => 1];

        foreach ($status as $key => $number) {
            \Turnover\Models\Transaction\Transaction::factory($number)->create([
                'status_id'   => $key,
                'customer_id' => $user->id
            ]);
        }

        foreach ($status as $key => $number) {
            $this->json('GET', 'api/transactions', ['status_id' => $key])
                 ->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['success', 'data'])
                 ->assertJsonCount($number, 'data')
                 ->assertJsonPath('data.0.customer_id', $user->id)
                 ->assertJsonPath('data.0.status_id', $key);
        }
    }

    public function test_must_visualize_without_transactions()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->json('GET', 'api/transactions')
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'data'])
             ->assertJsonCount(0, 'data');
    }
}
