<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IndonesianAdministrativeTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SuperadminUserSeeder::class);
        $this->call(DestinationTablesSeeder::class);
        $this->call(ExpeditionTablesSeeder::class);
    }
}
