<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Auth;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use App\User;
use DataTables;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Company;
use App\Models\Expedition;
/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('Paket Keluar', 'Input Paket keluar');
        $this->crud->setShowView('order.show');
    }

    protected function setupListOperation()
    {
        $this->crud->removeButton('delete');

        $this->crud->addButton('line', 'remove', 'view', 'crud::buttons.order.delete');

        $this->crud->addColumn([
            'name' => 'kode_truk',
            'type' => 'text',
            'label' => 'Kode Truk'
        ]);

       $this->crud->addColumn([
            'name' => 'perusahaan',
            'type' => 'select_from_array',
            'label' => 'Perusahaan',
            'options' => Company::active()->pluck('name', 'code')
        ]);

        $this->crud->addColumn([
            'name' => 'ekspedisi',
            'type' => 'select_from_array',
            'label' => 'Ekspedisi',
            'options' => Expedition::active()->pluck('name', 'code')
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
            'name' => 'user_id',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => 'App\User',
            'label' => 'Operator'
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OrderRequest::class);

        $this->crud->addField([
            'name' => 'perusahaan',
            'type' => 'select_from_array',
            'label' => 'Perusahaan',
            'options' => Company::active()->pluck('name', 'code')
        ]);

        $this->crud->addField([
            'name' => 'ekspedisi',
            'type' => 'select_from_array',
            'label' => 'Ekspedisi',
            'options' => Expedition::active()->pluck('name', 'code')
        ]);

        $this->crud->addField([
            'name' => 'surat_jalan',
            'type' => 'text',
            'label' => 'Surat Jalan'
        ]);

        $this->crud->addField([
            'name' => 'nama_driver',
            'type' => 'text',
            'label' => 'Driver'
        ]);

        $this->crud->addField([
            'name' => 'plat',
            'type' => 'text',
            'label' => 'Nomor Polisi Kendaraan'
        ]);

        $this->crud->addField([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Nomor HP driver'
        ]);

        $this->crud->addField([
            'name' => 'qty',
            'type' => 'number',
            'label' => 'Jumlah Total (QTY)',
            'hint' => 'Usahakan jangan scroll kolom dengan mouse karena nilai akan berubah'
        ]);

        $this->crud->addField([
            'name' => 'tanggal_kirim',
            'type' => 'date',
            'label' => 'Tanggal Kirim',
            'value' => date('Y-m-d')
        ]);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => Auth::id()
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store(OrderRequest $request)
    {
        return $this->traitStore();
    }

    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        $setFromDb = $this->crud->get('show.setFromDb');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.preview').' '.$this->crud->entity_name;

        // set columns from db
        if ($setFromDb) {
            $this->crud->setFromDb();
        }

        // cycle through columns
        foreach ($this->crud->columns() as $key => $column) {

            // remove any autoset relationship columns
            if (array_key_exists('model', $column) && array_key_exists('autoset', $column) && $column['autoset']) {
                $this->crud->removeColumn($column['key']);
            }

            // remove any autoset table columns
            if ($column['type'] == 'table' && array_key_exists('autoset', $column) && $column['autoset']) {
                $this->crud->removeColumn($column['key']);
            }

            // remove the row_number column, since it doesn't make sense in this context
            if ($column['type'] == 'row_number') {
                $this->crud->removeColumn($column['key']);
            }

            // remove columns that have visibleInShow set as false
            if (isset($column['visibleInShow']) && $column['visibleInShow'] == false) {
                $this->crud->removeColumn($column['key']);
            }

            // remove the character limit on columns that take it into account
            if (in_array($column['type'], ['text', 'email', 'model_function', 'model_function_attribute', 'phone', 'row_number', 'select'])) {
                $this->crud->modifyColumn($column['key'], ['limit' => 999]);
            }
        }

        // remove preview button from stack:line
        $this->crud->removeButton('show');

        // remove bulk actions colums
        $this->crud->removeColumns(['blank_first_column', 'bulk_actions']);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $model = $this->crud->model->findOrFail($id);

        if($model->order_details->count() > 0) {
            throw new HttpResponseException(
                response()->json(['success' => false, 'message' => 'Maaf data paket keluar ini masih memiliki data'], 422)
            );
        }
        
        return $this->crud->delete($id);
    }
}
