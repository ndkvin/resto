<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create one user with admin role
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
            'role' => 'ADMIN',  
        ]);

        User::create([
          'name' => 'manager',
          'email' => 'manager@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'MANAGER',  
        ]);

        User::create([
          'name' => 'cashier',
          'email' => 'cashier@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'CASHIER',  
        ]);
    }
}
