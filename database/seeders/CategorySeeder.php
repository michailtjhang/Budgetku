<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Gaji',
                'type' => 'income',
                'icon' => 'fas fa-money-bill-wave',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bonus',
                'type' => 'income',
                'icon' => 'fas fa-gift',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Hadiah',
                'type' => 'income',
                'icon' => 'fas fa-trophy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Investasi',
                'type' => 'income',
                'icon' => 'fas fa-chart-line',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Lainnya',
                'type' => 'income',
                'icon' => 'fas fa-ellipsis-h',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'name' => 'Makan',
                'type' => 'expense',
                'icon' => 'fas fa-utensils',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Transportasi',
                'type' => 'expense',
                'icon' => 'fas fa-car',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pendidikan',
                'type' => 'expense',
                'icon' => 'fas fa-book',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Hiburan',
                'type' => 'expense',
                'icon' => 'fas fa-film',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kesehatan',
                'type' => 'expense',
                'icon' => 'fas fa-heartbeat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Belanja',
                'type' => 'expense',
                'icon' => 'fas fa-shopping-cart',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Tagihan',
                'type' => 'expense',
                'icon' => 'fas fa-file-invoice-dollar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Lainnya',
                'type' => 'expense',
                'icon' => 'fas fa-ellipsis-h',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
