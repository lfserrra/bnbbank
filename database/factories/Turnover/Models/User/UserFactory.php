<?php

namespace Database\Factories\Turnover\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Turnover\Models\User\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Turnover\Models\User\User>
 */
class UserFactory extends Factory {

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'username' => $username = $this->faker->userName,
            'password' => Hash::make($username),
            'balance'  => 0,
            'is_admin' => false
        ];
    }
}
