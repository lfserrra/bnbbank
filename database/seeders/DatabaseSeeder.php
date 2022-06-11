<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Turnover\Models\User\User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'balance'  => 0,
            'is_admin' => true
        ]);

        \Turnover\Models\User\User::factory(10)->create();
    }
}
