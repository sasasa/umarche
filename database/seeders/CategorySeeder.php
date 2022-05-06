<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('primary_categories')->insert([
            [
                'name' => "キッズファッション",
                'sort_order' => 1,
                'created_at' => now(),
            ],
            [
                'name' => "出産祝い・ギフト",
                'sort_order' => 2,
                'created_at' => now(),
            ],
            [
                'name' => "ベビーカー",
                'sort_order' => 3,
                'created_at' => now(),
            ],
        ]);
        DB::table('secondary_categories')->insert([
            [
                'name' => "トップス",
                'sort_order' => 1,
                'created_at' => now(),
                'primary_category_id' => 1,
            ],
            [
                'name' => "靴",
                'sort_order' => 2,
                'created_at' => now(),
                'primary_category_id' => 1,
            ],
            [
                'name' => "ズボン",
                'sort_order' => 3,
                'created_at' => now(),
                'primary_category_id' => 1,
            ],
            [
                'name' => "ギフトセット",
                'sort_order' => 4,
                'created_at' => now(),
                'primary_category_id' => 2,
            ],
            [
                'name' => "メモリアル記念品",
                'sort_order' => 5,
                'created_at' => now(),
                'primary_category_id' => 2,
            ],
            [
                'name' => "おむつケーキ",
                'sort_order' => 6,
                'created_at' => now(),
                'primary_category_id' => 2,
            ],
        ]);
        
    }
}
