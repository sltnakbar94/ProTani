<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DownloadSalesFormRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DownloadSalesFormCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DownloadSalesFormCrudController extends CrudController
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
        CRUD::setModel('App\Models\DownloadSalesForm');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/downloadsalesform');
        CRUD::setEntityNameStrings('downloadsalesform', 'Download Form Sales');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (backpack_user()->hasRole('sales')) {
            $this->crud->addClause('where', 'user_id', '=', Auth::id());
        }

        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        $this->crud->removeButton('create');


        // $this->crud->addColumn([
        //     'name' => 'farmer_name',
        //     'label' => 'Nama Petani',
        //     'type' => 'select',
        //     'entity'    => 'downloadSalesForm',
        //     'attribute' => 'farmer_name',
        //     'model' => 'App/Models/Salesform'
        // ]);

        // $this->crud->addColumn([
        //     'name' => 'phone_number',
        //     'label' => 'No HP',
        //     'type' => 'select',
        //     'entity'    => 'downloadSalesForm',
        //     'attribute' => 'phone_number',
        //     'model' => 'App/Models/Salesform'
        // ]);

        // $this->crud->addColumn([
        //     'name' => 'id_number',
        //     'label' => 'No KTP',
        //     'type' => 'select',
        //     'entity'    => 'downloadSalesForm',
        //     'attribute' => 'id_number',
        //     'model' => 'App/Models/Salesform'
        // ]);

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
            'entity' => 'downloadSalesForm',
            'model' => 'App\Models\Regency',
            'label' => 'Kota/Kab'
        ]);

        $this->crud->addColumn([
            'name' => 'district',
            'type' => 'select',
            'entity' => 'downloadSalesForm',
            'model' => 'App\Models\District',
            'label' => 'Kecamatan'
        ]);

        $this->crud->addColumn([
            'name' => 'village',
            'type' => 'select',
            'entity' => 'downloadSalesForm',
            'model' => 'App\Models\Village',
            'label' => 'Kelurahan'
        ]);

        $this->crud->addColumn([
            'name' => 'rt',
            'label' => 'RT',
            'type' => 'select',
            'entity'    => 'downloadSalesForm',
            'attribute' => 'rt',
            'model' => 'App/Models/Salesform'
        ]);

        $this->crud->addColumn([
            'name' => 'rw',
            'label' => 'RW',
            'type' => 'select',
            'entity'    => 'downloadSalesForm',
            'attribute' => 'rw',
            'model' => 'App/Models/Salesform'
        ]);

        $this->crud->addColumn([
            'name' => 'id_address',
            'label' => 'Alamat KTP',
            'type' => 'select',
            'entity'    => 'downloadSalesForm',
            'attribute' => 'id_address',
            'model' => 'App/Models/Salesform'
        ]);


        $this->crud->addColumn([
            'name' => 'site_address',
            'label' => 'Lokasi Kolam',
            'type' => 'select',
            'entity'    => 'downloadSalesForm',
            'attribute' => 'site_address',
            'model' => 'App/Models/Salesform'
        ]);

        $this->crud->addColumn([
            'name' => 'user_id',
            'label' => 'Nama User',
            'type' => 'select',
            'entity'    => 'downloadSalesForm',
            'attribute' => 'user_id',
            'model' => 'App/Models/Salesform'
        ]);

        // $this->crud->addColumn([
        //     'name' => 'idpict',
        //     'label' => 'Foto',
        //     'type' => 'image',
        //     'prefix' => '/',
        //     'entity'    => 'downloadSalesForm',
        //     'attribute' => 'idpict',
        //     'model' => 'App/Models/Salesform'
        // ]);

        $this->crud->addColumn([
            'name' => 'pool_number',
            'type' => 'text',
            'label' => 'No Kolam'
        ]);

        $this->crud->addColumn([
            'name' => 'pool_large',
            'type' => 'text',
            'label' => 'Luas Kolam (m2)'
        ]);

        $this->crud->addColumn([
            'name' => 'pool_number',
            'type' => 'text',
            'label' => 'No Kolam'
        ]);

        $this->crud->addColumn([
            'name' => 'fish_type',
            'type' => 'text',
            'label' => 'Jenis Ikan'
        ]);

        $this->crud->addColumn([
            'name' => 'plant_date',
            'type' => 'text',
            'label' => 'Tanggal Penaburan'
        ]);

        $this->crud->addColumn([
            'name' => 'harvest_date',
            'type' => 'text',
            'label' => 'Tanggal Panen'
        ]);

        // $this->crud->addColumn([
        //     'name' => 'harvest_qty',
        //     'type' => 'text',
        //     'label' => 'Target Panen'
        // ]);

        $this->crud->addColumn([
            'name' => 'harvest_qty',
            'type' => 'text',
            'label' => 'Estimasi Hasil Panen (Kg)'
        ]);

        $this->crud->addColumn([
            'name' => 'result',
            'type' => 'text',
            'label' => 'Jumlah Panen (Kg)'
        ]);

        $this->crud->addColumn([
            'name' => 'lat',
            'type' => 'text',
            'label' => 'Latitude'
        ]);

        $this->crud->addColumn([
            'name' => 'lng',
            'type' => 'text',
            'label' => 'Longitude'
        ]);


        // $this->crud->addColumn([
        //     'name'      => 'sitepict', // The db column name
        //     'label'     => 'Foto Lokasi', // Table column heading
        //     'type'      => 'image',
        //     'prefix' => 'storage/'
        // ]);

        $this->crud->enableExportButtons();
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
        CRUD::setValidation(DownloadSalesFormRequest::class);

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
}
