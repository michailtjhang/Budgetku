<?php

namespace Database\Seeders;

use App\Models\Counter;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleSeeder::class
        ]);
    }
}
