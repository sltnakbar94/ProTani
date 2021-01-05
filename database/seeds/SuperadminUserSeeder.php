<?php

use Illuminate\Database\Seeder;
use App\User;

class SuperadminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user4 = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@bansoscovid19.id',
            'password' => bcrypt('BANSOS123!@#')
        ]);

        $user4->assignRole('superadmin');
    }
}
