<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Charts\SalesLineChart;

class ExportExcelController extends Controller
{
    public function show()
    {
        $data_detil = DB::table('order_details')->get();
        $data = DB::table('orders')->get();

        return view('export.show', ['data_detil' => $data_detil, 'data' => $data]);
    }

    public function export_excel()
    {
        return (new ExportExcel)->download('data.xlsx');
    }
}
