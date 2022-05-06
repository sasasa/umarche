<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<30; $i++) {
            DB::table('owners')->insert([
                [
                    'name' => "owner{$i}",
                    'email' => "owner{$i}@gmail.com",
                    'password' => Hash::make('passpass'),
                    'created_at' => '2021/01/01 11:11:11',
                ],
            ]);
        }
    }
}
