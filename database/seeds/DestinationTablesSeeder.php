<?php

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Destination::create([
            'code' => 'BGR',
            'name' => 'Bogor',
            'description' => 'Bogor',
        ]);
        Destination::create([
            'code' => 'TGR',
            'name' => 'Tangerang',
            'description' => 'Tangerang',
        ]);
        Destination::create([
            'code' => 'BKS',
            'name' => 'Bekasi',
            'description' => 'Bekasi',
        ]);
        Destination::create([
            'code' => 'DPK',
            'name' => 'Depok',
            'description' => 'Depok',
        ]);
        Destination::create([
            'code' => 'TGS',
            'name' => 'Tangerang Selatan',
            'description' => 'Tangerang Selatan',
        ]);
    }
}
