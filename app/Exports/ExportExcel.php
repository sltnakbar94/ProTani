<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportExcel implements FromView
{
    use Exportable;
    
    public function view(): View
    {
        return view('export.excel', [
            'datas' => Order::all(), 
            'data_detils' => OrderDetail::all()
        ]);
    }
}
