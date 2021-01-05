<?php

use Illuminate\Database\Seeder;

class IndonesianAdministrativeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(getcwd() . '/database/sql/provinces.sql'));
        DB::unprepared(file_get_contents(getcwd() . '/database/sql/regencies.sql'));
        DB::unprepared(file_get_contents(getcwd() . '/database/sql/districts.sql'));
        DB::unprepared(file_get_contents(getcwd() . '/database/sql/villages.sql'));
    }
}
