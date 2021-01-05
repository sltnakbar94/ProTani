<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderDetailManualRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderDetailManualCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderDetailManualCrudController extends CrudController
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
        CRUD::setModel(\App\Models\OrderDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order-scan');
        CRUD::setEntityNameStrings('Scan Paket', 'Scan Paket');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addButton('line', 'confirm_scan', 'view', 'crud::buttons.order-scan.confirm');

        // CRUD::setFromDb(); // columns
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('show');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('nomor_order')->label('Nomor Pengiriman');
        CRUD::column('tujuan')->label('Tujuan');
        CRUD::column('qty')->label('Jumlah')->type('number');
        CRUD::addColumn([
            'label' => 'Ekspedisi',
            'name' => 'order_id', 
            'type' => 'select',
            'entity' => 'order',
            'attribute' => 'ekspedisi',
            'model' => 'App\Models\Order'
        ]);
        CRUD::addColumn([
            'label' => 'Surat Jalan',
            'name' => 'order_id', 
            'type' => 'select',
            'entity' => 'order',
            'key' => 'sj',
            'attribute' => 'surat_jalan',
            'model' => 'App\Models\Order'
        ]);
        CRUD::column('created_at')->label('Tanggal Proses');

        $this->crud->addClause('where', 'status_terima', '=', 0);
        $this->crud->addClause('where', 'status_order', '=', 1);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderDetailManualRequest::class);

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
