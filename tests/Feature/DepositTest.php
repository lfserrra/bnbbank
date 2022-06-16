<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\TransactionCheck\TransactionCheck;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class DepositTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_must_enter_amount_description_and_check()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->json('POST', 'api/deposit')
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

    public function test_must_fail_because_admin_cant_deposit()
    {
        $user = \Turnover\Models\User\User::factory()->create(['is_admin' => 1]);
        Sanctum::actingAs($user, ['*']);

        Storage::fake('local');
        $file = UploadedFile::fake()->image('check.jpg');

        $data = [
            'amount'      => 50.99,
            'description' => 'First deposit',
            'check'       => $file
        ];

        $this->json('POST', 'api/deposit', $data)
             ->assertStatus(403);
    }

    public function test_must_successful_create_transaction()
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

        $result = $this->json('POST', 'api/deposit', $data)
                       ->assertStatus(200)
                       ->assertJsonPath('success', true)
                       ->assertJsonStructure(['success', 'transaction'])
                       ->assertJsonPath('transaction.status_id', TransactionStatus::PENDING)
                       ->assertJsonPath('transaction.type_id', TransactionType::DEPOSIT)
                       ->assertJsonPath('transaction.customer_id', $user->id);

        $transaction_id    = $result['transaction']['id'];
        $transaction_check = TransactionCheck::where('transaction_id', $transaction_id)->first();

        Storage::disk('local')->assertExists($transaction_check->url);
    }

    public function test_must_successful_download_check_image()
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

        $result = $this->json('POST', 'api/deposit', $data)
                       ->assertStatus(200)
                       ->assertJsonPath('success', true)
                       ->assertJsonStructure(['success', 'transaction'])
                       ->assertJsonPath('transaction.status_id', TransactionStatus::PENDING)
                       ->assertJsonPath('transaction.type_id', TransactionType::DEPOSIT)
                       ->assertJsonPath('transaction.customer_id', $user->id);

        $transaction_id = $result['transaction']['id'];

        $this->get("api/transactions/$transaction_id/image")
             ->assertStatus(200);
    }
}
