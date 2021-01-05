<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'code' => 'ALA',
            'name' => 'ALA',
        ]);

        Company::create([
            'code' => 'JUNA',
            'name' => 'JUNA',
        ]);
    }
}
