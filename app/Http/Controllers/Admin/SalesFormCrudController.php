<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class SalesFormCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalesFormCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SalesForm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/salesform');
        CRUD::setEntityNameStrings('salesform', 'Form Sales');
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
        CRUD::setValidation(SalesFormRequest::class);
        $province = DB::table('provinces')->get();
        $regencies = DB::table('regencies')->get();
        $districts = DB::table('districts')->get();
        $villages = DB::table('villages')->get();

        $this->crud->addField([
            'name'            => 'farmer_name',
            'label'           => "Nama Petani",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'phone_number',
            'label'           => "Nomor HP Petani",
            'type'            => 'text',
            'hint'            => '08XXXXXXXXXX',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'provinces',
            'label'           => "Provinsi",
            'type'            => 'select_from_array',
            'options'         => $province->pluck('name'),
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'regencies',
            'label'           => "Kecamatan",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'districts',
            'label'           => "Kelurahan",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'villages',
            'label'           => "Kota/Desa",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'rt',
            'label'           => "RT",
            'type'            => 'number',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'rw',
            'label'           => "RW",
            'type'            => 'number',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'id_address',
            'label'           => "Alamat",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'label' => "Foto KTP",
            'name' => "idpict",
            'type' => 'image',
            'tab'             => 'Data Diri',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'name'            => 'site_address',
            'label'           => "Alamat Lokasi",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'pool_qty',
            'label'           => "Jumlah Kolam",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'pool_large',
            'label'           => "Luas Kolam",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'fish_type',
            'label'           => "Jenis Ikan",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'plant_date',
            'label'           => "Mulai Penebaran",
            'type'            => 'date_picker',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'harvest_date',
            'label'           => "Target Panen",
            'type'            => 'date_picker',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'label' => "Foto Lokasi",
            'name' => "sitepict1",
            'type' => 'image',
            'tab'             => 'Data Lokasi',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Foto Lokasi",
            'name' => "sitepict2",
            'type' => 'image',
            'tab'             => 'Data Lokasi',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Foto Lokasi",
            'name' => "sitepict3",
            'type' => 'image',
            'tab'             => 'Data Lokasi',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Foto Lokasi",
            'name' => "sitepict4",
            'type' => 'image',
            'tab'             => 'Data Lokasi',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'label' => "Foto Lokasi",
            'name' => "sitepict5",
            'type' => 'image',
            'tab'             => 'Data Lokasi',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            'disk'      => 'public', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        $this->crud->addField([
            'name'            => 'lat',
            'label'           => "lat",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'lng',
            'label'           => "lng",
            'type'            => 'text',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'description',
            'label'           => "Catatan",
            'type'            => 'textarea',
            'tab'             => 'Catatan',
        ]);

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
}
