<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        //Regular Users
        DB::table('users')->insert([
            'name' => 'Seu Madruga',
            'email' => 'madruga@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('password'),
            'cpf' => '854.937.770-88',
            'hourly_price' => 13,
        ]);

        DB::table('users')->insert([
            'name' => 'Chiquinha',
            'email' => 'chiquinha@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('password'),
            'cpf' => '049.878.910-18',
            'hourly_price' => 11,
        ]);

        DB::table('users')->insert([
            'name' => 'Chaves',
            'email' => 'chaves@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('password'),
            'cpf' => '445.981.110-38',
            'hourly_price' => 20,
        ]);

        //Admins
        DB::table('users')->insert([
            'name' => 'Dona Clotilde',
            'email' => 'clotilde@gmail.com',
            'role_id' => 2,
            'password' => bcrypt('password'),
            'cpf' => '236.509.450-37',
        ]);

        DB::table('users')->insert([
            'name' => 'Chapolin Colorado',
            'email' => 'chapolin@gmail.com',
            'role_id' => 2,
            'password' => bcrypt('password'),
            'cpf' => '789.861.180-25',
        ]);
    }
}
