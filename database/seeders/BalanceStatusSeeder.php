<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\BalanceStatus\BalanceStatus;

class BalanceStatusSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BalanceStatus::create(['description' => 'Pending']);
        BalanceStatus::create(['description' => 'Accepted']);
        BalanceStatus::create(['description' => 'Rejected']);
    }
}
