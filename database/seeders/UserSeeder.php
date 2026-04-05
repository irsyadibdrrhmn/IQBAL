<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'ismail',
                'email' => 'ismail1234@gmail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Johari',
                'email' => 'johari123@gmail.com',
                'role' => 'owner',
            ],
            [
                'name' => 'dede irawan',
                'email' => 'Dedeirawan@gmail.com',
                'role' => 'customer',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => Hash::make('password'), // Password default
            ]);
        }
    }
}
