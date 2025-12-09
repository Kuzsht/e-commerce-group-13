<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Ventela',
                'email' => 'ventela@gmail.com',
                'role' => 'member',
                'password' => Hash::make('ventela123'),
            ],
            [
                'name' => 'Admin KIKSup',
                'email' => 'kicksup@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Raditya',
                'email' => 'rdtkw05@gmail.com',
                'role' => 'member',
                'password' => Hash::make('anu123'),
            ],
            [
                'name' => 'Admin Nike',
                'email' => 'nike@gmail.com',
                'role' => 'member',
                'password' => Hash::make('nike123'),
            ],
            [
                'name' => 'Admin Adidas',
                'email' => 'adidas@gmail.com',
                'role' => 'member',
                'password' => Hash::make('adidas123'),
            ],
            [
                'name' => 'Admin The North Face',
                'email' => 'tnf@gmail.com',
                'role' => 'member',
                'password' => Hash::make('tnf123'),
            ],
            [
                'name' => 'Admin Puma',
                'email' => 'puma@gmail.com',
                'role' => 'member',
                'password' => Hash::make('puma123'),
            ],
            [
                'name' => 'Admin Vans',
                'email' => 'vans@gmail.com',
                'role' => 'member',
                'password' => Hash::make('vans123'),
            ],
            [
                'name' => 'Admin New Balance',
                'email' => 'nbc@gmail.com',
                'role' => 'member',
                'password' => Hash::make('nbc123'),
            ],
            [
                'name' => 'Admin Asics',
                'email' => 'asics@gmail.com',
                'role' => 'member',
                'password' => Hash::make('asics123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}