<?php

namespace Database\Factories\Turnover\Models\Balance;

use Illuminate\Database\Eloquent\Factories\Factory;
use Turnover\Models\Balance\Balance;
use Turnover\Models\BalanceType\BalanceType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Turnover\Models\Balance\Balance>
 */
class BalanceFactory extends Factory {

    protected $model = Balance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type_id = $this->faker->numberBetween(1, 3);
        $amount  = $this->faker->randomFloat(2, 0.01, 1000);

        if ($type_id !== BalanceType::DEPOSIT) {
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
