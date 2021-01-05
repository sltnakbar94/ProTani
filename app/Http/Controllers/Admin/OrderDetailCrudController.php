<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderDetailRequest;
use App\Http\Requests\OrderDetailUpdateRequest;
use App\Http\Requests\CheckPointRequest;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\OrderDetail;
use App\Models\OrderDetailManual;
use App\Jobs\ProcessResizeOrderReceivedImage;
use Str;
use Auth;
use QrCode;
/**
 * Class OrderDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\OrderDetail');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/orderdetail');
        $this->crud->setEntityNameStrings('orderdetail', 'order_details');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OrderDetailRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function edit(Request $request, $id)
    {
        return OrderDetail::findOrFail($id);
    }

    public function generateNomorPengiriman($request)
    {
        $code = [
            'Bogor' => 'BGR',
            'Tangerang' => 'TGR',
            'Bekasi' => 'BKS',
            'Depok' => 'DPK',
            'Tangerang Selatan' => 'TGS',
        ];

        $shipper = $request->get('shipper');
        $tujuan = $code[$request->tujuan];
        $unique = $shipper.$tujuan;

        $count = OrderDetail::withTrashed()->whereRaw("LEFT(nomor_order, 6) = '$unique'")->count();

        $number = str_pad($count + 1,7,"0",STR_PAD_LEFT);

        $generate = $unique. $number;

        return $generate;
    }

    public function store(OrderDetailRequest $request)
    {
       $order_detail = OrderDetail::create([
           'order_id' => $request->order_id, 
           'nomor_order' => $this->generateNomorPengiriman($request), 
           'tujuan' => $request->tujuan, 
           'qty' => $request->qty, 
           'url' => Str::uuid()->toString(), 
           'user_id' => Auth::id(), 
           'status_order' => $request->filled('pre_order') ? 0 : 1
       ]);
    
        \Alert::add('success', 'Berhasil tambah data order ' . $order_detail->nomor_order)->flash();
       return response()->json([
           'success' => true,
           'message' => 'Berhasil tambah data order ' . $order_detail->nomor_order,
           'url' => route('orderdetail.show-qrcode', $order_detail->url)
       ], 200);
    }

    public function update(OrderDetailUpdateRequest $request, $id)
    {
        $order_detail = OrderDetail::findOrFail($id);
        $order_detail->tujuan = $request->tujuan;
        $order_detail->qty = $request->qty;
        $order_detail->status_order = $request->filled('pre_order') ? 0 : 1;
        $order_detail->save();

        \Alert::add('success', 'Berhasil memperbarui data order ' . $order_detail->nomor_order)->flash();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui data order ' . $order_detail->nomor_order
        ], 200);
    }

    public function destroy($id)
    {
        $order_detail = OrderDetail::findOrFail($id);
        $order_detail->delete();
        
        \Alert::add('success', 'Berhasil hapus data order')->flash();
        return redirect()->back();
    }

    public function qrManualScan($id)
    {
        // flag status_scan = 1 & status_terima 1
        $order_detail = OrderDetail::findOrFail($id);
        $qty = $order_detail->qty;
        $order_detail->status_terima = 1;
        $order_detail->status_scan = 1;
        $order_detail->jumlah_diterima = $qty;
        $order_detail->save();

        // insert to new table order_detail_manuals
        $order_detail_manual = new OrderDetailManual;
        $order_detail_manual->order_detail_id = $order_detail->id;
        $order_detail_manual->tujuan = $order_detail->tujuan;
        $order_detail_manual->ekspedisi = $order_detail->order->ekspedisi;
        $order_detail_manual->surat_jalan = $order_detail->order->surat_jalan;
        $order_detail_manual->qty = $order_detail->qty;
        $order_detail_manual->user_id = $order_detail->user_id;
        $order_detail_manual->save();
    }

    public function showQrCode($url)
    {
        $order_detail = OrderDetail::whereUrl($url)->firstOrFail();

        return view('order.qrcode', compact('url', 'order_detail'));
    }

    public function showForm($url)
    {
        $found = OrderDetail::whereStatusTerima('1')->whereUrl($url)->first();

        if($found) {
            return redirect()->route('qrcode-show-data', $url);
        }

        $order_detail = OrderDetail::whereStatusTerima('0')->whereUrl($url)->firstOrFail();
        return view('order.check-point', compact('order_detail'));
    }

    public function submitForm(CheckPointRequest $request, $url)
    {
        $order_detail = OrderDetail::whereStatusTerima('0')->whereUrl($url)->firstOrFail();
        $order_detail->status_terima = 1;
        $order_detail->jumlah_diterima = $request->jumlah_diterima;
        $order_detail->nama_penerima = strtoupper($request->nama_penerima);
        $order_detail->hp_penerima = $request->hp_penerima;
        $order_detail->lat = $request->lat;
        $order_detail->lng = $request->lng;

        $file = $request->file('foto_ktp');
        $path = $file->storeAs('order-received', strtolower($order_detail->nomor_order) . '.' . $file->getClientOriginalExtension() , 'public');

        $order_detail->foto_ktp = $path;
        $order_detail->tanggal_terima = date('Y-m-d H:i:s');
        $order_detail->save();

        ProcessResizeOrderReceivedImage::dispatch($order_detail)->delay(now()->addSeconds(3));

        return redirect()->route('qrcode-show-data', $url);
    }

    public function successForm($url)
    {
        $order_detail = OrderDetail::whereStatusTerima('1')->whereUrl($url)->firstOrFail();
        return view('order.check-point-show', compact('order_detail'));
    }

}
