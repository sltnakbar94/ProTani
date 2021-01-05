<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class SuperadminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'superadmin']);
    }
}
