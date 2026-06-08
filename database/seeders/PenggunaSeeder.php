<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([[
            'id_role' => 1,
            'username' => 'nathan',
            'password' => bcrypt('password123')

        ],[
            'id_role' => 2,
            'username' => 'user1',
            'password' => bcrypt('password123')
        ],[
            'id_role' => 2,
            'username' => 'user2',
            'password' => bcrypt('password123')
        ]]);
    }
}
