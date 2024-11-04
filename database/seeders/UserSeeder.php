<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id_user' => 'US001',
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$h35n179sl3nou9lWblC6yevURZ6kZ0MNwO2OZA4NDDP.5Lo2LVU3S',
                'remember_token' => 'Nva6F0XDgIOemmMj4w3QjMSemLLv1D3WItvrTwn036KrqJoqMxHpDRey8zms',
                'created_at' => '2024-09-24 20:23:18',
                'updated_at' => '2024-09-24 20:23:18'
            ]
        ]);
    }
}
