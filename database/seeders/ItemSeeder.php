<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '컷트',
                'memo' => '컷트상세',
                'price' => 6000,
            ],
            [
                'name' => '염색',
                'memo' => '염색상세',
                'price' => 8000,
            ],
            [
                'name' => '펌(컷 포함)',
                'memo' => '펌상세',
                'price' => 13000,
            ],
        ]);
    }
}
