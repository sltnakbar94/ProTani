<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DownloadRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DownloadCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DownloadCrudController extends CrudController
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
        $this->crud->setModel('App\Models\OrderDetail');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/download');
        $this->crud->setEntityNameStrings('Download All', 'Report');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        $this->crud->removeButton('create');
        $this->crud->removeColumn(['url', 'status_order', 'jumlah_diterima', 'hp_penerima', 'foto_ktp', 'lat', 'lng', 'status_terima', 'user_id']);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'date',
            'label' => 'Tanggal Kirim'
          ],
        false,
        function ($value) {
            $this->crud->query->select(['orders.tanggal_kirim', 'order_details.*'])->join('orders', 'orders.id', '=', 'order_details.order_id')->whereRaw('DATE(tanggal_kirim) = "'. $value .'"');
        });

        $this->crud->addColumn([
            'name' => 'order_id',
            'type' => 'select',
            'label' => 'Kode Truk',
            'entity'    => 'order',
            'attribute' => 'kode_truk',
            'model' => 'App/Models/Order'
        ]);

         $this->crud->addColumn([
            'name' => 'nomor_order',
            'type' => 'text',
            'label' => 'Nomor Pengiriman'
        ]);

         $this->crud->addColumn([
            'name' => 'tujuan',
            'type' => 'text',
            'label' => 'Tujuan'
        ]);

         $this->crud->addColumn([
            'name' => 'qty',
            'type' => 'number',
            'label' => 'QTY'
        ]);
        $this->crud->addColumn([
            'name' => 'jumlah_diterima',
            'type' => 'text',
            'label' => 'Jumlah Terima'
        ]);
         $this->crud->addColumn([
            'name' => 'nama_penerima',
            'type' => 'text',
            'label' => 'Nama Penerima'
        ]);



       $this->crud->addColumn([
            'name' => 'perusahaan',
            'type' => 'select',
            'label' => 'Perusahaan',
            'entity'    => 'order',
            'attribute' => 'perusahaan',
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'ekspedisi',
            'type' => 'select',
            'label' => 'Ekspedisi',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'ekspedisi', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'surat_jalan',
            'type' => 'select',
            'label' => 'Surat Jalan',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'surat_jalan', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'nama_driver',
            'type' => 'select',
            'label' => 'Driver',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'nama_driver', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'plat',
            'type' => 'select',
            'label' => 'Nomor Polisi',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'plat', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'qty',
            'type' => 'select',
            'label' => 'Jumlah Total (QTY)',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'qty', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'tanggal_kirim',
            'type' => 'select',
            'label' => 'Tanggal Kirim',
            'entity'    => 'order', // the method that defines the relationship in your Model
            'attribute' => 'delivery_date', // foreign key attribute that is shown to user
            'model' => 'App/Models/Order'
        ]);

        $this->crud->addColumn([
            'name' => 'status_order',
            'type' => 'select_from_array',
            'label' => 'Status Paket',
            'options' => [
                '0' => 'Pre-Order',
                '1' => 'Paket',
            ]
        ]);

        $this->crud->addColumn([
            'name' => 'status_terima',
            'type' => 'select_from_array',
            'label' => 'Status Pengiriman',
            'options' => [
                '0' => 'Dalam Pengiriman',
                '1' => 'Terkirim',
            ]
        ]);

        $this->crud->enableExportButtons();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DownloadRequest::class);

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
