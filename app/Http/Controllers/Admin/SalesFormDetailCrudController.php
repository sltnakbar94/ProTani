<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\SalesFormDetail;

/**
 * Class SalesFormDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalesFormDetailCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SalesFormDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/salesformdetail');
        CRUD::setEntityNameStrings('salesformdetail', 'sales_form_details');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SalesFormDetailRequest::class);

        CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store(SalesFormDetailRequest $request)
    {
       $form_detail = SalesFormDetail::create([
           'sales_form_id' => $request->sales_form_id,
           'pool_large' => $this->generateNomorPengiriman($request),
           'fish_type' => $request->tujuan,
           'plant_date' => $request->qty,
           'harvest_date' => $request->qty,
           'harvest_qty' => $request->qty,
           'sitepict' => $request->qty,
           'result' => $request->qty,
           'status' => $request->qty,
           'lat' => Str::uuid()->toString(),
           'lng' => Str::uuid()->toString(),
           'user_id' => Auth::id(),
       ]);

        \Alert::add('success', 'Berhasil tambah data order ' . $form_detail->nomor_order)->flash();
       return response()->json([
           'success' => true,
           'message' => 'Berhasil tambah data order ' . $form_detail->nomor_order,
           'url' => route('orderdetail.show-qrcode', $form_detail->url)
       ], 200);
    }
}
