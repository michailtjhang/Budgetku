<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'id' => '01j8kkd0j357ddxkdq75etr7q2',
                'name' => 'Admin',
                'created_at' => '2024-09-24 20:25:36',
                'updated_at' => '2024-09-24 20:25:36'
            ],
            [
                'id' => '01j8kkdk3abh0a671dr5rqkshy',
                'name' => 'User',
                'created_at' => '2024-09-24 20:25:55',
                'updated_at' => '2024-09-24 20:25:55'
            ]
        ]);
    }
}
