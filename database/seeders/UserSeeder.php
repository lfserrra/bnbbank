<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Turnover\Models\User\User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'admin',
            'balance'  => 0,
            'is_admin' => true
        ]);

        \Turnover\Models\User\User::factory(2)->create();
    }
}
