<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Turnover\Models\Balance\Balance;
use Turnover\Models\BalanceCheck\BalanceCheck;
use Turnover\Models\BalanceStatus\BalanceStatus;
use Turnover\Models\BalanceType\BalanceType;

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

    public function test_must_successful_create_balance()
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
                       ->assertJsonPath('balance.status_id', BalanceStatus::PENDING)
                       ->assertJsonPath('balance.type_id', BalanceType::DEPOSIT)
                       ->assertJsonPath('balance.customer_id', $user->id);

        $balance_id    = $result['balance']['id'];
        $balance_check = BalanceCheck::where('balance_id', $balance_id)->first();

        Storage::disk('local')->assertExists($balance_check->url);
    }

    public function test_must_visualize_balance()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $balance = Balance::create([
            'status_id'   => BalanceStatus::ACCEPTED,
            'type_id'     => BalanceType::ORDER,
            'customer_id' => $user->id,
            'amount'      => -50.99,
            'description' => 'First order',
        ]);

        $this->json('GET', 'api/balances/' . $balance->id)
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'balance'])
             ->assertJsonPath('balance.status_id', BalanceStatus::ACCEPTED)
             ->assertJsonPath('balance.type_id', BalanceType::ORDER)
             ->assertJsonPath('balance.customer_id', $user->id);
    }

    public function test_must_fail_visualize_balance_another_customer()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $balance = Balance::create([
            'status_id'   => BalanceStatus::ACCEPTED,
            'type_id'     => BalanceType::ORDER,
            'customer_id' => 3,
            'amount'      => 100.99,
            'description' => 'First deposit',
        ]);

        $this->json('GET', 'api/balances/' . $balance->id)
             ->assertNotFound();
    }

    public function test_must_visualize_my_list_of_balances()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        \Turnover\Models\Balance\Balance::factory(2)->create(['type_id' => BalanceType::DEPOSIT, 'customer_id' => $user->id]);
        \Turnover\Models\Balance\Balance::factory(3)->create(['type_id' => BalanceType::ORDER, 'customer_id' => $user->id]);
        \Turnover\Models\Balance\Balance::factory(1)->create(['type_id' => BalanceType::WITHDRAW, 'customer_id' => $user->id]);

        //No filters
        $this->json('GET', 'api/balances')
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'data'])
             ->assertJsonCount(6, 'data')
             ->assertJsonPath('data.0.customer_id', $user->id);
    }

    public function test_must_visualize_my_list_of_balances_with_filtered_types()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $types = [BalanceType::DEPOSIT => 2, BalanceType::ORDER => 3, BalanceType::WITHDRAW => 1];

        foreach ($types as $type => $number) {
            \Turnover\Models\Balance\Balance::factory($number)->create([
                'type_id'     => $type,
                'customer_id' => $user->id
            ]);
        }

        foreach ($types as $type => $number) {
            $this->json('GET', 'api/balances', ['type_id' => $type])
                 ->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['success', 'data'])
                 ->assertJsonCount($number, 'data')
                 ->assertJsonPath('data.0.customer_id', $user->id)
                 ->assertJsonPath('data.0.type_id', $type);
        }
    }

    public function test_must_visualize_my_list_of_balances_with_filtered_status()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $status = [BalanceStatus::PENDING => 2, BalanceStatus::ACCEPTED => 3, BalanceStatus::REJECTED => 1];

        foreach ($status as $key => $number) {
            \Turnover\Models\Balance\Balance::factory($number)->create([
                'status_id'   => $key,
                'customer_id' => $user->id
            ]);
        }

        foreach ($status as $key => $number) {
            $this->json('GET', 'api/balances', ['status_id' => $key])
                 ->assertStatus(200)
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['success', 'data'])
                 ->assertJsonCount($number, 'data')
                 ->assertJsonPath('data.0.customer_id', $user->id)
                 ->assertJsonPath('data.0.status_id', $key);
        }
    }

    public function test_must_visualize_without_balances()
    {
        $user = \Turnover\Models\User\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $this->json('GET', 'api/balances')
             ->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonStructure(['success', 'data'])
             ->assertJsonCount(0, 'data');
    }
}
