<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Auth;

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
        CRUD::setEntityNameStrings('Form Sales', 'Form Sales');
        $this->crud->setShowView('order.show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'farmer_name',
            'type' => 'text',
            'label' => 'Nama Petani'
        ]);

        $this->crud->addColumn([
            'name' => 'phone_number',
            'type' => 'text',
            'label' => 'No HP'
        ]);

        $this->crud->addColumn([
            'name' => 'id_number',
            'type' => 'text',
            'label' => 'No KTP'
        ]);

        $this->crud->addColumn([
            'name' => 'province',
            'type' => 'select',
            'entity' => 'province',
            'model' => 'App\Models\Province',
            'label' => 'Provinsi'
        ]);

        $this->crud->addColumn([
            'name' => 'regency',
            'type' => 'select',
            'entity' => 'regency',
            'model' => 'App\Models\Regency',
            'label' => 'Kota/Kab'
        ]);

        $this->crud->addColumn([
            'name' => 'district',
            'type' => 'select',
            'entity' => 'district',
            'model' => 'App\Models\District',
            'label' => 'Kecamatan'
        ]);

        $this->crud->addColumn([
            'name' => 'village',
            'type' => 'select',
            'entity' => 'village',
            'model' => 'App\Models\Village',
            'label' => 'Kelurahan'
        ]);

        $this->crud->addColumn([
            'name' => 'rt',
            'type' => 'number',
            'label' => 'RT'
        ]);

        $this->crud->addColumn([
            'name' => 'rw',
            'type' => 'number',
            'label' => 'RW'
        ]);

        $this->crud->addColumn([
            'name' => 'id_address',
            'type' => 'text',
            'label' => 'Alamat KTP'
        ]);

        $this->crud->addColumn([
            'name' => 'id_address',
            'type' => 'text',
            'label' => 'Alamat KTP'
        ]);

        $this->crud->addColumn([
            'name' => 'site_address',
            'type' => 'text',
            'label' => 'Alamat Lokasi'
        ]);

        $this->crud->addColumn([
            'name'      => 'idpict', // The db column name
            'label'     => 'Foto', // Table column heading
            'type'      => 'image',
            'prefix' => 'storage/public/',
            // image from a different disk (like s3 bucket)
            // 'disk'   => 'disk-name',
            // optional width/height if 25px is not ok with you
            // 'height' => '30px',
            // 'width'  => '30px',
        ]);

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

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => Auth::id()
        ]);

        $this->crud->addField([
            'name'            => 'farmer_name',
            'label'           => "Nama Petani",
            'type'            => 'text',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'id_number',
            'label'           => "Nomor KTP",
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
            'name'            => 'province_id',
            'label'           => "Provinsi",
            'type'            => 'select2_from_ajax',
            'entity'          => 'province',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Provinsi',
            'minimum_input_length' => 0,
            'data_source'     => url('api/province'),
            'model'           => 'App\Models\Province',
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'regency_id',
            'label'           => "Kota",
            'type'            => 'select2_from_ajax',
            'entity'          => 'regency',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kab/Kota',
            'minimum_input_length' => 0,
            'data_source'     => url('api/regency'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['province_id'],
            'include_all_form_fields' => true,
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'district_id',
            'label'           => "Kecamatan",
            'type'            => 'select2_from_ajax',
            'entity'          => 'district',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kecamatan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/district'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['regency_id'] ,
            'include_all_form_fields' => true,
            'tab'             => 'Data Diri',
        ]);

        $this->crud->addField([
            'name'            => 'village_id',
            'label'           => "Kel/Desa",
            'type'            => 'select2_from_ajax',
            'entity'          => 'village',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kelurahan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/village'),
            'model'           => 'App\Models\Village',
            'dependencies'    => ['district_id'] ,
            'include_all_form_fields' => true,
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
            'label' => "Foto",
            'name' => "idpict",
            'type' => 'image',
            'tab'             => 'Data Diri',
            'crop' => true, // set to true to allow cropping, false to disable
            'upload' => true,
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
            'type'            => 'number',
            'tab'             => 'Data Lokasi',
        ]);

        $this->crud->addField([
            'name'            => 'description',
            'label'           => "Catatan",
            'type'            => 'textarea',
            'tab'             => 'Data Lokasi',
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
