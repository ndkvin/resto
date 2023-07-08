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
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
            'role' => 'ADMIN',  
        ]);

        User::create([
          'name' => 'Admin 2',
          'email' => 'adminku@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'ADMIN',  
       ]);

        User::create([
          'name' => 'Manager',
          'email' => 'manager@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'MANAGER',  
        ]);

        User::create([
          'name' => 'Cashier Cahya',
          'email' => 'cashiercahya@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'CASHIER',  
        ]);

        User::create([
          'name' => 'Cashier Amar',
          'email' => 'cashieramar@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'CASHIER',  
        ]);

        User::create([
          'name' => 'Cashier Sintya',
          'email' => 'cashiersintya@gmail.com',
          'password' => bcrypt('123123123'),
          'role' => 'CASHIER',  
        ]);
    }
}
