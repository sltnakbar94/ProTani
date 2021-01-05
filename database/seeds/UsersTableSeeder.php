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
        $user1 = User::create([
            'name' => 'Operator 1',
            'email' => 'operator1@example.com',
            'password' => bcrypt('password')
        ]);

        $user1->assignRole('operator');

        $user2 = User::create([
            'name' => 'Operator 2',
            'email' => 'operator2@example.com',
            'password' => bcrypt('password')
        ]);

        $user2->assignRole('operator');

        $user3 = User::create([
            'name' => 'Operator 3',
            'email' => 'operator3@example.com',
            'password' => bcrypt('password')
        ]);

        $user3->assignRole('operator');

        $user4 = User::create([
            'name' => 'Operator 4',
            'email' => 'operator4@example.com',
            'password' => bcrypt('password')
        ]);

        $user4->assignRole('operator');

        $user5 = User::create([
            'name' => 'Operator 5',
            'email' => 'operator5@example.com',
            'password' => bcrypt('password')
        ]);

        $user5->assignRole('operator');

        $eksekutif = User::create([
            'name' => 'Eksekutif 1',
            'email' => 'eksekutif@example.com',
            'password' => bcrypt('password')
        ]);

        $eksekutif->assignRole('eksekutif');
    }
}
