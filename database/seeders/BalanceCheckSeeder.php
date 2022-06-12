<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\Balance\Balance;
use Turnover\Models\BalanceType\BalanceType;

class BalanceCheckSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balances = Balance::where('type_id', BalanceType::DEPOSIT)->get();

        foreach ($balances as $balance) {
            $balance->check()->create([
                'url' => 'checks/generated_by_seeder.jpg'
            ]);
        }
    }
}
