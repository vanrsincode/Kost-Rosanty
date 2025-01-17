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
        $user = [
            [
                'name' => 'Demo Administrator',
                'email' => 'demo_admin@email.com',
                'password' => bcrypt('KostRosanty00'),
                'text' => 'KostRosanty00',
                'role' => 1
            ],
            [
                'name' => 'Demo Pemilik',
                'email' => 'demo_pemilik@email.com',
                'password' => bcrypt('KostRosanty00'),
                'text' => 'KostRosanty00',
                'role' => 3
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
