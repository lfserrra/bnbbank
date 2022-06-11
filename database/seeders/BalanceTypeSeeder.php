<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\BalanceType\BalanceType;

class BalanceTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BalanceType::create(['description' => 'Deposit']);
        BalanceType::create(['description' => 'Order']);
        BalanceType::create(['description' => 'Withdraw']);
    }
}
