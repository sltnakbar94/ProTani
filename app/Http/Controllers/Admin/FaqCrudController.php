<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FaqRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FaqCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FaqCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Faq');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/faq');
        $this->crud->setEntityNameStrings('FAQ', 'FAQs');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->addColumn([
            'name' => 'question',
            'type' => 'textarea',
            'label' => 'Question'
        ]);

        $this->crud->addColumn([
            'name' => 'answer',
            'type' => 'textarea',
            'label' => 'Answer'
        ]);

        $this->crud->addColumn([
            'name' => 'active',
            'type' => 'check',
            'label' => 'Active'
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(FaqRequest::class);

        $this->crud->addField([
            'name' => 'question',
            'type' => 'textarea',
            'label' => 'Question'
        ]);

        $this->crud->addField([
            'name' => 'answer',
            'type' => 'textarea',
            'label' => 'Answer'
        ]);

        $this->crud->addField([
            'name' => 'active',
            'type' => 'checkbox',
            'label' => 'Active'
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
