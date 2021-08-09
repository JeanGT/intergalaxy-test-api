<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesheetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 06:00:00',
            'end_time' => '2021-08-06 12:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 13:00:00',
            'end_time' => '2021-08-06 15:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 06:00:00',
            'end_time' => '2021-08-07 12:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 13:00:00',
            'end_time' => '2021-08-07 15:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 08:00:00',
            'end_time' => '2021-08-09 12:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 13:00:00',
            'end_time' => '2021-08-09 17:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 08:00:00',
            'end_time' => '2021-08-10 12:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 13:00:00',
            'end_time' => '2021-08-10 17:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-11 08:00:00',
            'end_time' => '2021-08-11 12:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-12 13:00:00',
            'end_time' => '2021-08-12 17:00:00',
            'user_id' => 1,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 07:00:00',
            'end_time' => '2021-08-06 12:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 12:30:00',
            'end_time' => '2021-08-06 15:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 06:30:00',
            'end_time' => '2021-08-07 12:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 13:00:00',
            'end_time' => '2021-08-07 18:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 06:00:00',
            'end_time' => '2021-08-09 12:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 13:00:00',
            'end_time' => '2021-08-09 17:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 08:00:00',
            'end_time' => '2021-08-10 11:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 9:00:00',
            'end_time' => '2021-08-10 17:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-11 08:00:00',
            'end_time' => '2021-08-11 11:00:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-12 13:00:00',
            'end_time' => '2021-08-12 17:30:00',
            'user_id' => 2,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 05:00:00',
            'end_time' => '2021-08-06 12:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-06 12:30:00',
            'end_time' => '2021-08-06 11:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 06:30:00',
            'end_time' => '2021-08-07 14:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-07 11:00:00',
            'end_time' => '2021-08-07 18:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 06:00:00',
            'end_time' => '2021-08-09 11:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-09 13:30:00',
            'end_time' => '2021-08-09 17:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 08:00:00',
            'end_time' => '2021-08-10 11:30:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-10 9:15:00',
            'end_time' => '2021-08-10 17:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-11 08:00:00',
            'end_time' => '2021-08-11 12:00:00',
            'user_id' => 3,
        ]);

        DB::table('timesheets')->insert([
            'start_time' => '2021-08-12 13:00:00',
            'end_time' => '2021-08-12 17:45:00',
            'user_id' => 3,
        ]);
    }
}
