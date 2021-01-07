<?php

use Illuminate\Database\Seeder;

use App\User;
use Illuminate\Support\Str;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = User::create([
            'name' => 'sales 1',
            'email' => 'sales@example.com',
            'password' => bcrypt('password')
        ]);

        $sales->assignRole('sales');

        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@lumbungtani.org',
            'password' => bcrypt('Ltani123!@#')
        ]);

        $superadmin->assignRole('superadmin');
    }
}
