<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\SalesFormDetail;
use App\Jobs\ProcessResizeFormDetailImage;
use Illuminate\Http\Request;
use Auth;

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

        $form_detail = new SalesFormDetail;
        $form_detail->sales_form_id = $request->sales_form_id;
        $form_detail->pool_number = $request->pool_number;
        $form_detail->pool_large = $request->pool_large;
        $form_detail->fish_type = $request->fish_type;
        $form_detail->plant_date = $request->plant_date;
        $form_detail->harvest_date = $request->harvest_date;
        $form_detail->harvest_qty = $request->harvest_qty;
        $form_detail->result = $request->result;
        $form_detail->province_id = $request->province_id;
        $form_detail->regency_id = $request->regency_id;
        $form_detail->district_id = $request->district_id;
        $form_detail->village_id = $request->village_id;
        $form_detail->lat = $request->lat;
        $form_detail->lng = $request->lng;
        if($request->hasFile('sitepict')) {
            $file = $request->file('sitepict');
            $path = $file->storeAs('form_details', strtolower($form_detail->sales_form_id) .'-' . date('Ymdhis') . '.' . $file->getClientOriginalExtension() , 'public');
            $form_detail->sitepict = $path;
        }
        $form_detail->save();

        if($request->hasFile('foto')) {
            ProcessResizeFormDetailImage::dispatch($form_detail)->delay(now()->addSeconds(3));
        }

        \Alert::add('success', 'Berhasil tambah data order ' . $form_detail->pool_number)->flash();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $form_detail = SalesFormDetail::findOrFail($id);
        $form_detail->delete();

        \Alert::add('success', 'Berhasil hapus data order')->flash();
        return redirect()->back();
    }
}
