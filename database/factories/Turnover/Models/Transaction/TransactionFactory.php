<?php

namespace Database\Factories\Turnover\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\Factory;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionType\TransactionType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Turnover\Models\Transaction\Transaction>
 */
class TransactionFactory extends Factory {

    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type_id = $this->faker->numberBetween(1, 2);
        $amount  = $this->faker->randomFloat(2, 0.01, 1000);

        if ($type_id === TransactionType::PURCHASE) {
            $amount = $amount * -1;
        }

        return [
            'status_id'   => $this->faker->numberBetween(1, 3),
            'type_id'     => $type_id,
            'customer_id' => $this->faker->numberBetween(2, 3),
            'amount'      => $amount,
            'description' => $this->faker->sentence(3)
        ];
    }
}
