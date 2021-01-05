<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Charts\SalesLineChart;
use App\Models\OrderDetail;
use App\Models\Produksi;
use Carbon;
use DB;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {

        return view(backpack_view('dashboard'), $this->data);
    }

    public function dashboardMap()
    {
        $this->data['locations'] = NULL;

        return view(backpack_view('dashboard-map'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        if(backpack_user()->hasRole('operator')) {
            return redirect(backpack_url('order'));
        }
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }

    public function showSelectedDate()
    {
        $produksi = Produksi::whereDate('tanggal', request('show_dashboard_date', date('Y-m-d')))->sum('qty');
        $stok_paket = Produksi::whereDate('tanggal', request('show_dashboard_date', date('Y-m-d')))->sum('qty') - OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')))->sum('order_details.qty');
        $paket_keluar = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')))->sum('order_details.qty');
        $sedang_dikirim = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->where('status_terima', 0)->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')))->sum('order_details.qty');
        $sampai_ketujuan = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_terima', '>', 0)->whereDate('orders.tanggal_kirim', request('show_dashboard_date', date('Y-m-d')))->sum('order_details.qty');

        // redis check here
        $this->data['dashboard'] = [
            'total_produksi' => [
                'progress' => ($produksi > 0) ? ($produksi / $produksi) * 100 : 0,
                'count' => $produksi,
            ],
            'stok_paket' => [
                'progress' => ($produksi > 0) ? ($stok_paket / $produksi) * 100 : 0,
                'count' => $stok_paket,
            ],
            'paket_keluar' => [
                'progress' => ($produksi > 0) ? ($paket_keluar / $produksi)  * 100 : 0,
                'count' => $paket_keluar,
            ],
            'sedang_dikirim' => [
                'progress' => ($paket_keluar > 0) ? ($sedang_dikirim / $paket_keluar) * 100 : 0,
                'count' => $sedang_dikirim,
            ],
            'sampai_ketujuan' => [
                'progress' => ($paket_keluar > 0) ? ($sampai_ketujuan / $paket_keluar) * 100 : 0,
                'count' => $sampai_ketujuan,
            ],
        ];

        // $this->data['locations'] = OrderDetail::whereStatusOrder(1)->whereStatusTerima(1)->whereDate('tanggal_terima', date('Y-m-d'))->whereNotNull('lat')->whereNotNull('lng')->get();
    }

    public function showToday()
    {
        $produksi = Produksi::whereDate('tanggal', date('Y-m-d'))->sum('qty');
        $stok_paket = Produksi::whereDate('tanggal', date('Y-m-d'))->sum('qty') - OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->whereDate('orders.tanggal_kirim', date('Y-m-d'))->sum('order_details.qty');
        $paket_keluar = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->whereDate('orders.tanggal_kirim', date('Y-m-d'))->sum('order_details.qty');
        $sedang_dikirim = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_order', 1)->where('status_terima', 0)->whereDate('orders.tanggal_kirim', date('Y-m-d'))->sum('order_details.qty');
        $sampai_ketujuan = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')->where('status_terima', '>', 0)->whereDate('orders.tanggal_kirim', date('Y-m-d'))->sum('order_details.qty');

        // redis check here
        $this->data['dashboard'] = [
            'total_produksi' => [
                'progress' => ($produksi > 0) ? ($produksi / $produksi) * 100 : 0,
                'count' => $produksi,
            ],
            'stok_paket' => [
                'progress' => ($produksi > 0) ? ($stok_paket / $produksi) * 100 : 0,
                'count' => $stok_paket,
            ],
            'paket_keluar' => [
                'progress' => ($produksi > 0) ? ($paket_keluar / $produksi)  * 100 : 0,
                'count' => $paket_keluar,
            ],
            'sedang_dikirim' => [
                'progress' => ($paket_keluar > 0) ? ($sedang_dikirim / $paket_keluar) * 100 : 0,
                'count' => $sedang_dikirim,
            ],
            'sampai_ketujuan' => [
                'progress' => ($paket_keluar > 0) ? ($sampai_ketujuan / $paket_keluar) * 100 : 0,
                'count' => $sampai_ketujuan,
            ],
        ];

        // $this->data['locations'] = OrderDetail::whereStatusOrder(1)->whereStatusTerima(1)->whereDate('tanggal_terima', date('Y-m-d'))->whereNotNull('lat')->whereNotNull('lng')->get();
    }

    public function showAll()
    {
        $produksi = Produksi::sum('qty');
        $stok_paket = Produksi::sum('qty') - OrderDetail::where('status_order', 1)->sum('qty');
        $paket_keluar = OrderDetail::where('status_order', 1)->sum('qty');
        $sedang_dikirim = OrderDetail::where('status_order', 1)->where('status_terima', 0)->where('status_terima', 0)->sum('qty');
        $sampai_ketujuan = OrderDetail::where('status_terima', '>', 0)->sum('qty');

        // redis check here
        $this->data['dashboard'] = [
            'total_produksi' => [
                'progress' => ($produksi > 0) ? ($produksi / $produksi) * 100 : 0,
                'count' => $produksi,
            ],
            'stok_paket' => [
                'progress' => ($produksi > 0) ? ($stok_paket / $produksi) * 100 : 0,
                'count' => $stok_paket,
            ],
            'paket_keluar' => [
                'progress' => ($produksi > 0) ? ($paket_keluar / $produksi)  * 100 : 0,
                'count' => $paket_keluar,
            ],
            'sedang_dikirim' => [
                'progress' => ($paket_keluar > 0) ? ($sedang_dikirim / $paket_keluar) * 100 : 0,
                'count' => $sedang_dikirim,
            ],
            'sampai_ketujuan' => [
                'progress' => ($paket_keluar > 0) ? ($sampai_ketujuan / $paket_keluar) * 100 : 0,
                'count' => $sampai_ketujuan,
            ],
        ];

        // $this->data['locations'] = OrderDetail::whereStatusOrder(1)->whereStatusTerima(1)->whereNotNull('lat')->whereNotNull('lng')->get();
    }

    public function renderModal()
    {
        $this->renderModalPaketKeluar();
        $this->renderModalPaketSedangDikirim();
        $this->renderModalPaketSampaiKetujuan();
    }

    // load modal dashboard here
    public function renderModalPaketKeluar()
    {
        $builder = app('datatables.html');
        $dt_paket_keluar = $builder->ajax([
                                'url' => route('dt.paket-keluar'),
                                'type' => 'GET',
                                'data' => 'function(d){ d.show_dashboard = $("body").find("select[name=show_dashboard]").val(); d.show_dashboard_date = $("body").find("input[name=show_dashboard_date]").val(); }'
                            ])
                            ->columns([
                                ['data' => 'kode_truk', 'name' => 'orders.kode_truk', 'title' => 'Kode Truk'],
                                ['data' => 'nomor_order', 'name' => 'nomor_order', 'title' => 'Nomor Pengiriman'],
                                ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan'],
                                ['data' => 'qty', 'name' => 'qty', 'title' => 'Jumlah'],
                                ['data' => 'ekspedisi', 'name' => 'orders.ekspedisi', 'title' => 'Ekspedisi'],
                                ['data' => 'surat_jalan', 'name' => 'orders.surat_jalan', 'title' => 'Surat Jalan']
                            ])->parameters([
                                    'order' => [
                                        0,
                                        'desc'
                                    ]
                            ]);


        $this->data['dt_paket_keluar'] = $dt_paket_keluar;
    }

    public function renderModalPaketSedangDikirim()
    {
        $builder = app('datatables.html');
        $dt_paket_dikirim = $builder->ajax([
                                'url' => route('dt.paket-dikirim'),
                                'type' => 'GET',
                                'data' => 'function(d){ d.show_dashboard = $("body").find("select[name=show_dashboard]").val(); d.show_dashboard_date = $("body").find("input[name=show_dashboard_date]").val(); }'
                            ])
                            ->columns([
                                ['data' => 'kode_truk', 'name' => 'orders.kode_truk', 'title' => 'Kode Truk'],
                                ['data' => 'nomor_order', 'name' => 'nomor_order', 'title' => 'Nomor Pengiriman'],
                                ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan'],
                                ['data' => 'qty', 'name' => 'qty', 'title' => 'Jumlah'],
                                ['data' => 'ekspedisi', 'name' => 'orders.ekspedisi', 'title' => 'Ekspedisi'],
                                ['data' => 'surat_jalan', 'name' => 'orders.surat_jalan', 'title' => 'Surat Jalan']
                            ])->parameters([
                                    'order' => [
                                        0,
                                        'desc'
                                    ]
                            ]);


        $this->data['dt_paket_dikirim'] = $dt_paket_dikirim;
    }

    public function renderModalPaketSampaiKetujuan()
    {
        $builder = app('datatables.html');
        $dt_paket_ditujuan = $builder->ajax([
                                'url' => route('dt.paket-ditujuan'),
                                'type' => 'GET',
                                'data' => 'function(d){ d.show_dashboard = $("body").find("select[name=show_dashboard]").val(); d.show_dashboard_date = $("body").find("input[name=show_dashboard_date]").val(); }'
                            ])
                            ->columns([
                                ['data' => 'kode_truk', 'name' => 'orders.kode_truk', 'title' => 'Kode Truk'],
                                ['data' => 'nomor_order', 'name' => 'nomor_order', 'title' => 'Nomor Pengiriman'],
                                ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan'],
                                ['data' => 'qty', 'name' => 'qty', 'title' => 'Jumlah'],
                                ['data' => 'jumlah_diterima', 'name' => 'jumlah_diterima', 'title' => 'Jumlah Diterima'],
                                ['data' => 'ekspedisi', 'name' => 'orders.ekspedisi', 'title' => 'Ekspedisi'],
                                ['data' => 'surat_jalan', 'name' => 'orders.surat_jalan', 'title' => 'Surat Jalan'],
                                ['data' => 'tanggal_terima', 'name' => 'tanggal_terima', 'title' => 'Tanggal Terima'],
                                ['data' => 'action', 'name' => 'action', 'title' => 'Detail', 'searchable' => false, 'orderable' => false],
                            ])->parameters([
                                    'order' => [
                                        0,
                                        'desc'
                                    ]
                            ]);


        $this->data['dt_paket_ditujuan'] = $dt_paket_ditujuan;
    }

    // data KPM
    public function kpmData($request)
    {
        $response = [];

        $ed = DB::table('expedition_destinations')
                            ->selectRaw("expedition_destinations.expedition_id, destinations.name, quota")
                            ->leftJoin('destinations', 'destinations.code', '=', 'expedition_destinations.destination_id')
                            ->orderBy('expedition_id')
                            ->orderBy('destination_id')
                            ->get();



        foreach($ed as $row) {
            $response[$row->name]['expedition'] = $row->expedition_id;
            $response[$row->name]['name'] = $row->name;
            $response[$row->name]['quota'] = $row->quota;
            $query = OrderDetail::selectRaw("
                                max(orders.ekspedisi) as ekspedisi,
                                order_details.tujuan,
                                max(destinations.quota) as kuota_paket,
                                sum(order_details.qty) as paket_keluar,
                                sum(order_details.jumlah_diterima) as paket_diterima,
                                (SELECT COUNT(DISTINCT(orders.id)) FROM orders JOIN order_details ON order_details.order_id = orders.id  WHERE ekspedisi = orders.ekspedisi AND order_details.tujuan = destinations.name) as total_truk,
                                (max(destinations.quota) - sum(order_details.qty)) as sisa_paket
                                ")
                                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                                ->join('destinations', 'destinations.name', '=', 'order_details.tujuan')
                                ->where('ekspedisi', $row->expedition_id)
                                ->where('tujuan', $row->name);

            if($request->get('show_dashboard') == 'set_date') {
                $query = $query->whereDate('orders.tanggal_kirim', $request->get('show_dashboard_date', date('Y-m-d')));
            } else if($request->get('show_dashboard') == 'today') {
                $query = $query->whereDate('orders.tanggal_kirim', date('Y-m-d'));
            }

            $query = $query->groupBy('tujuan')
            ->first();

            $response[$row->name]['data'] = $query;
        }



        $this->data['kpms'] = $response;
    }

    public function listReceived()
    {
        $builder = app('datatables.html');
        $list = $builder->ajax([
                                'url' => route('dt.list-received'),
                                'type' => 'GET',
                                'data' => 'function(d){ d.show_dashboard = $("body").find("select[name=show_dashboard]").val(); d.show_dashboard_date = $("body").find("input[name=show_dashboard_date]").val(); }'
                            ])
                            ->columns([
                                ['data' => 'kode_truk', 'name' => 'orders.kode_truk', 'title' => 'Kode Truk'],
                                ['data' => 'tujuan', 'name' => 'tujuan', 'title' => 'Tujuan'],
                                ['data' => 'nomor_order', 'name' => 'nomor_order', 'title' => 'Nomor Pengiriman'],
                                ['data' => 'qty', 'name' => 'qty', 'title' => 'Jumlah'],
                                ['data' => 'plat', 'name' => 'orders.plat', 'title' => 'Nomor Kendaraan'],
                                ['data' => 'nama_driver', 'name' => 'orders.nama_driver', 'title' => 'Pengemudi']
                            ]);

        $this->data['list'] = $list;
    }
}
