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
        DB::table('owners')->insert([
            [
                'name' => 'owner1',
                'email' => 'owner1@gmail.com',
                'password' => Hash::make('passpass'),
                'created_at' => '2021/01/01 11:11:11',
            ],
            [
                'name' => 'owner2',
                'email' => 'owner2@gmail.com',
                'password' => Hash::make('passpass'),
                'created_at' => '2021/01/01 11:11:11',
            ],
            [
                'name' => 'owner3',
                'email' => 'owner3@gmail.com',
                'password' => Hash::make('passpass'),
                'created_at' => '2021/01/01 11:11:11',
            ],
        ]);
    }
}
