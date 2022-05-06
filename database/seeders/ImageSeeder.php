<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample1.jpg',
            'created_at' => now(),
            ],
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample2.jpg',
            'created_at' => now(),
            ],
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample3.jpg',
            'created_at' => now(),
            ],
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample4.jpg',
            'created_at' => now(),
            ],
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample5.jpg',
            'created_at' => now(),
            ],
            [
            'owner_id' => 1,
            'title' => null,
            'filename' => 'sample6.jpg',
            'created_at' => now(),
            ],
        ]);

        collect(['sample1.jpg','sample2.jpg','sample3.jpg','sample4.jpg','sample5.jpg','sample6.jpg'])->each(function($img){
            $from = public_path("images/{$img}");
            $to = storage_path("app/public/products/{$img}");
            file_put_contents($to, file_get_contents($from));
        });
        
    }
}
