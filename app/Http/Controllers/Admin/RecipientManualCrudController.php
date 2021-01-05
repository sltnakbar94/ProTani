<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecipientManualRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RecipientManualCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecipientManualCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RecipientManual::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/recipient-manual');
        CRUD::setEntityNameStrings('KPM', 'KPM');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nik')->type('text')->label('NIK');
        CRUD::column('nama')->type('text')->label('Nama Lengkap');
        CRUD::column('alamat')->type('textarea')->label('Alamat');

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
        CRUD::setValidation(RecipientManualRequest::class);

        CRUD::field('nik')->type('text')->label('NIK');
        CRUD::field('nama')->type('text')->label('Nama Lengkap');
        CRUD::field('alamat')->type('textarea')->label('Alamat');
        $this->crud->addFields([
            [
                'name'  => 'regency_id',
                'label' => "Kab/Kota",
                'type'  => 'select2_from_ajax',
                'entity' => 'regency',
                'attribute' => 'name',
                'placeholder' => 'Pilih Kab/Kota',
                'minimum_input_length' => 0,
                'data_source' => url('api/regency'),
                'model' => 'App\Models\Regency',
                'dependencies' => [],
                'include_all_form_fields' => false
            ],
            [
                'name'  => 'district_id',
                'label' => "Kecamatan",
                'type'  => 'select2_from_ajax',
                'entity' => 'district',
                'attribute' => 'name',
                'placeholder' => 'Pilih Kecamatan',
                'minimum_input_length' => 0,
                'data_source' => url('api/district'),
                'model' => 'App\Models\District',
                'dependencies' => ['regency_id'] ,
                'include_all_form_fields' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name'  => 'village_id',
                'label' => "Kelurahan",
                'type'  => 'select2_from_ajax',
                'entity' => 'village',
                'attribute' => 'name',
                'placeholder' => 'Pilih Kelurahan',
                'minimum_input_length' => 0,
                'data_source' => url('api/village'),
                'model' => 'App\Models\Village',
                'dependencies' => ['district_id', 'regency_id'] ,
                'include_all_form_fields' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ]
        ]);

        CRUD::field('rt')->type('text')->label('RT')->size(4);
        CRUD::field('rw')->type('text')->label('RW')->size(4);
        CRUD::field('kode_pos')->type('text')->label('Kode Pos')->size(4);
        CRUD::field('lat')->type('text')->label('Latitude');
        CRUD::field('lng')->type('text')->label('Longitude');
        CRUD::field('foto')->type('upload')->label('Foto')->disk('public')->upload(true)->attributes(['accept' => 'image/*']);

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
