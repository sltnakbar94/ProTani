<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NotificationUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NotificationUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\NotificationUser');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/notification-user');
        $this->crud->setEntityNameStrings('Notification User', 'Notification users');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        /**
        * id
        * userable_id
        * userable_type
        * token
        * data
        * active
         */
        $this->crud->setColumns([
            [
                'name' => 'token',
                'type' => 'text',
                'label' => 'Token'
            ],
            [
                'name' => 'data',
                'type' => 'text',
                'label' => 'Data',
            ],
            [
                'name' => 'active',
                'type' => 'checkbox',
                'label' => 'Active',
            ],
        ]);

        $this->crud->removeButtons(['create', 'delete', 'update']);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(NotificationUserRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
