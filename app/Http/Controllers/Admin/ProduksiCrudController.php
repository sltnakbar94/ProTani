<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProduksiRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Auth;

/**
 * Class ProduksiCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProduksiCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Produksi');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/produksi');
        $this->crud->setEntityNameStrings('produksi', 'produksi');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();
        // $this->crud->setColumns(['qty']);
        $this->crud->addColumn([
            'name' => 'tanggal',
            'type' => 'date',
            'label' => 'Tanggal'
        ]);
        $this->crud->addColumn([
            'name' => 'qty',
            'type' => 'number',
            'label' => 'Qty'
        ]);

        $this->crud->enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProduksiRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();
        $this->crud->addField([
            'name' => 'tanggal',
            'type' => 'hidden',
            'value' => now()
        ]);
        $this->crud->addField([
            'name' => 'qty',
            'type' => 'number',
            'label' => "Quantity"
        ]);

        $this->crud->addField([
            'name'  => 'user_id',
            'type'  => 'hidden',
            'value' => Auth::id(),
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
