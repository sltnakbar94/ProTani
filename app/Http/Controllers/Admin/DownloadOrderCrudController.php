<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DownloadOrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DownloadOrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DownloadOrderCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/downloadorder');
        CRUD::setEntityNameStrings('downloadorder', 'download orders');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        $this->crud->removeButton('create');

        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'date',
            'label' => 'Tanggal Kirim'
          ],
            false,
            function ($value) {
                $this->crud->query->whereRaw('DATE(tanggal_kirim) = "'. $value .'"');
            });

        $this->crud->addColumn([
            'name' => 'kode_truk',
            'type' => 'text',
            'label' => 'Kode Truk'
        ]);

       $this->crud->addColumn([
            'name' => 'perusahaan',
            'type' => 'select_from_array',
            'label' => 'Perusahaan',
            'options' => [
                'ALA' => 'ALA',
                'JUNA' => 'JUNA',
            ]
        ]);

        $this->crud->addColumn([
            'name' => 'ekspedisi',
            'type' => 'select_from_array',
            'label' => 'Ekspedisi',
            'options' => [
                'POS' => 'POS',
                'PTP' => 'PRIMA',
            ]
        ]);

        $this->crud->addColumn([
            'name' => 'surat_jalan',
            'type' => 'text',
            'label' => 'Surat Jalan'
        ]);

        $this->crud->addColumn([
            'name' => 'nama_driver',
            'type' => 'text',
            'label' => 'Driver'
        ]);

        $this->crud->addColumn([
            'name' => 'plat',
            'type' => 'text',
            'label' => 'Nomor Polisi'
        ]);

        $this->crud->addColumn([
            'name' => 'qty',
            'type' => 'number',
            'label' => 'Jumlah Total (QTY)'
        ]);

        $this->crud->addColumn([
            'name' => 'tanggal_kirim',
            'type' => 'date',
            'label' => 'Tanggal Kirim'
        ]);

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
        CRUD::setValidation(DownloadOrderRequest::class);

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
