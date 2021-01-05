<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailManual;
use App\Models\Produksi;
use App\Models\Recipient;
use App\Models\RecipientManual;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::query()->delete();
        OrderDetail::query()->delete();
        OrderDetailManual::query()->delete();
        Produksi::query()->delete();
        Recipient::query()->delete();
        RecipientManual::query()->delete();
    }
}
