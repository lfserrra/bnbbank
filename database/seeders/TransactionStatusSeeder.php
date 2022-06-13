<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\TransactionStatus\TransactionStatus;

class TransactionStatusSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionStatus::create(['description' => 'Pending']);
        TransactionStatus::create(['description' => 'Accepted']);
        TransactionStatus::create(['description' => 'Rejected']);
    }
}
