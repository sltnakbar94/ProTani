<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use DataTables;
use Carbon\Carbon;
use Storage;
class DashboardController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    public function ajaxPaketKeluar()
    {
        if(request()->ajax()) {
            $query = OrderDetail::leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                            ->where('status_order', 1)->select(['order_details.*', 'orders.ekspedisi', 'orders.surat_jalan', 'orders.kode_truk']);

            if(request()->get('show_dashboard') == 'set_date') {
                $query = $query->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')));
            }

            if(request()->get('show_dashboard') == 'today') {
                $query = $query->whereDate('orders.tanggal_kirim', date('Y-m-d'));
            }

            return DataTables::of($query)->toJson();
        }
    }

    public function ajaxPaketDikirim()
    {
        if(request()->ajax()) {
            $query = OrderDetail::leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                            ->where('status_order', 1)
                            ->where('status_terima', 0)
                            ->select(['order_details.*', 'orders.ekspedisi', 'orders.surat_jalan', 'orders.kode_truk']);

            if(request()->get('show_dashboard') == 'set_date') {
                $query = $query->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')));
            }

            if(request()->get('show_dashboard') == 'today') {
                $query = $query->whereDate('orders.tanggal_kirim', date('Y-m-d'));
            }

            return DataTables::of($query)->toJson();
        }
    }

    public function ajaxPaketDitujuan()
    {
        if(request()->ajax()) {
            $query = OrderDetail::leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                            ->where('status_order', 1)
                            ->where('status_terima', '>', 0)
                            ->select(['order_details.*', 'orders.ekspedisi', 'orders.surat_jalan', 'orders.kode_truk']);

            if(request()->get('show_dashboard') == 'set_date') {
                $query = $query->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')));
            }

            if(request()->get('show_dashboard') == 'today') {
                $query = $query->whereDate('orders.tanggal_kirim', date('Y-m-d'));
            }

            return DataTables::of($query)
                    ->editColumn('tanggal_terima', function($row){
                        return Carbon::parse($row->tanggal_terima)->format('d F Y - H:i');
                    })
                    ->editColumn('action', function($row){
                        $url = route('order-received.detail', $row->id);
                        return "<button type='button' class='btn btn-success order-received-btn' id='$url' data-toggle='modal' data-target='#showModalPaketDitujuanDetail'><i class='fa fa-eye'></i></button>";
                    })
                    ->toJson();
        }
    }

    public function ajaxReceived()
    {
        if(request()->ajax()) {
            $query = OrderDetail::leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                            ->where('status_order', 1)
                            ->select(['order_details.*', 'orders.ekspedisi', 'orders.surat_jalan', 'orders.nama_driver', 'orders.plat', 'orders.kode_truk']);

            return DataTables::of($query)
                    ->editColumn('tanggal_terima', function($row){
                        return Carbon::parse($row->tanggal_terima)->format('d F Y - H:i');
                    })
                    ->editColumn('action', function($row){
                        $url = route('order-received.detail', $row->id);
                        return "<button type='button' class='btn btn-success order-received-btn' id='$url' data-toggle='modal' data-target='#showModalPaketDitujuanDetail'><i class='fa fa-eye'></i></button>";
                    })
                    ->toJson();
        }
    }

    public function received($id)
    {
        // order-received.detail
        $order_detail = OrderDetail::findOrFail($id);
        return [
            'data' => [
                'nomor_order' => $order_detail->nomor_order,
                'tujuan' => $order_detail->tujuan,
                'qty' => $order_detail->qty,
                'ekspedisi' => $order_detail->order->ekspedisi,
                'surat_jalan' => $order_detail->order->surat_jalan,
                'tanggal_terima' => Carbon::parse($order_detail->tanggal_terima)->format('d F Y - H:i'),
                'nama_penerima' => $order_detail->nama_penerima,
                'jumlah_diterima' => $order_detail->jumlah_diterima,
                'hp_penerima' => $order_detail->hp_penerima,
                'foto' => Storage::disk('public')->url($order_detail->foto_ktp),
            ]
        ];
    }

}
