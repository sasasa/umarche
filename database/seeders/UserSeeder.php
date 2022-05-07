<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<30; $i++) {
            DB::table('users')->insert([
                [
                    'name' => "user{$i}",
                    'email' => "user{$i}@gmail.com",
                    'password' => Hash::make('passpass'),
                    'created_at' => now(),
                ],
            ]);
        }
    }
}
