<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\TransactionType\TransactionType;

class TransactionTypeSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::create(['description' => 'Deposit']);
        TransactionType::create(['description' => 'Purchase']);
    }
}
