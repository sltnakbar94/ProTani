<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Outlet;
use App\Models\Role;
use App\Models\District;

$district = District::all()->random();

$factory->define(User::class, function (Faker $faker) use ($district) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'picture' => 'dummy/profile.jpg',
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'province_id' => $district->regency->province->id,
        'regency_id' => $district->regency->id,
        'district_id' => $district->id,
        'postal_code' => '12240'
    ];
});

// set as role