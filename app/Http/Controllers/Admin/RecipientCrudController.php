<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RecipientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Jobs\ProcessResizeRecipientImage;
use App\Models\Recipient;
/**
 * Class RecipientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RecipientCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Recipient::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/recipient');
        CRUD::setEntityNameStrings('recipient', 'recipients');
        
       
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

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
        CRUD::setValidation(RecipientRequest::class);

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

    public function showForm()
    {
        return view('recipient.form');
    }

    public function submitForm(RecipientRequest $request)
    {
        $recipient = new Recipient;
        $recipient->nama = strtoupper($request->nama);
        $recipient->alamat = $request->alamat;
        $recipient->regency_id = $request->regency_id;
        $recipient->district_id = $request->district_id;
        $recipient->village_id = $request->village_id;
        $recipient->rt = $request->rt;
        $recipient->rw = $request->rw;
        $recipient->kode_pos = $request->kode_pos;
        $recipient->nik = $request->nik;
        $recipient->lat = $request->lat;
        $recipient->lng = $request->lng;

        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->storeAs('recipients', strtolower($recipient->nik) .'-' . date('Ymdhis') . '.' . $file->getClientOriginalExtension() , 'public');
            $recipient->foto = $path;
        }
        $recipient->save();

        if($request->hasFile('foto')) {
            ProcessResizeRecipientImage::dispatch($recipient)->delay(now()->addSeconds(3));
        }
        

        return view('recipient.thankyou', compact('recipient'));
    }

}
