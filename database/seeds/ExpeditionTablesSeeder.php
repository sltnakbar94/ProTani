<?php

use Illuminate\Database\Seeder;
use App\Models\Expedition;

class ExpeditionTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Expedition::create([
            'code' => 'POS',
            'name' => 'POS',
            'description' => 'PT. Pos Indonesia',
        ]);

        Expedition::create([
            'code' => 'PTP',
            'name' => 'PRIMA',
            'description' => 'PRIMA',
        ]);
    }
}
