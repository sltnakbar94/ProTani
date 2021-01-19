<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ValidateRequest;
use App\Models\SalesForm;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class ValidateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ValidateCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Validate::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/validate');
        CRUD::setEntityNameStrings('validate', 'validates');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $duplicates = DB::table('sales_forms')
            ->select('id' ,'village_id','rt','rw', DB::raw('COUNT(*) as `count`'))
            ->groupBy('village_id', 'rw', 'rt')
            ->havingRaw('COUNT(*) > 1');
        if ($duplicates->first() != NULL) {
            foreach ($duplicates->get() as $key) {
                $this->crud->addClause('where', 'village_id', '=', $key->village_id);
                $this->crud->addClause('where', 'rw', '=', $key->rw);
                $this->crud->addClause('where', 'rt', '=', $key->rt);
            }
            $this->crud->orderBy('village_id', 'ASC');
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
                'name' => 'site_address',
                'type' => 'text',
                'label' => 'Alamat Kolam'
            ]);

            $this->crud->addColumn([
                'name' => 'user_id',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => 'App\User',
                'label' => 'Nama User'
            ]);
        } else {
            $this->crud->addClause('where', 'id', '=', 0);
            $this->crud->orderBy('village_id', 'ASC');
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
                'name' => 'site_address',
                'type' => 'text',
                'label' => 'Alamat Kolam'
            ]);

            $this->crud->addColumn([
                'name' => 'user_id',
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => 'App\User',
                'label' => 'Nama User'
            ]);
        }


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
        CRUD::setValidation(ValidateRequest::class);

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
