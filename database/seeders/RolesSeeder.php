<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'user',
            'id' => 1
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'id' => 2
        ]);
    }
}
