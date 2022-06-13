<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionType\TransactionType;

class TransactionCheckSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::where('type_id', TransactionType::DEPOSIT)->get();

        foreach ($transactions as $transaction) {
            $transaction->check()->create([
                'url' => 'checks/generated_by_seeder.jpg'
            ]);
        }
    }
}
