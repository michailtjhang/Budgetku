<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permission_role')->insert([
            [
                'id' => '9d185d88-a9a8-477e-bd83-b6eb9b38410f',
                'permission_id' => 2,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-ae52-4f6f-9de4-7575df69b48d',
                'permission_id' => 3,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-afaa-4915-834b-6912ec66fcff',
                'permission_id' => 4,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-b0f2-48a5-82a7-f17e0c5d9c77',
                'permission_id' => 5,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-b24d-4512-86e6-f1dd3d98d88f',
                'permission_id' => 6,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-b3bf-4165-85f0-edf906251203',
                'permission_id' => 7,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-b504-4390-baa9-5a05374ee610',
                'permission_id' => 8,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ],
            [
                'id' => '9d185d88-b660-409a-85ca-65e5c9b05d4a',
                'permission_id' => 9,
                'role_id' => '01j8kkd0j357ddxkdq75etr7q2',
                'created_at' => '2024-09-25 08:55:40',
                'updated_at' => '2024-09-25 08:55:40'
            ]
        ]);
    }
}
