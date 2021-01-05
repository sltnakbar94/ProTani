<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationMessageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Notifications\SendMessage as SendMessageNotification;
/**
 * Class NotificationMessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NotificationMessageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\NotificationMessage');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/notification-message');
        $this->crud->setEntityNameStrings('Notification Message', 'Notification Messages');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setColumns([
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Title'
            ],
            [
                'name' => 'body',
                'type' => 'text',
                'label' => 'Body',
            ],
            [
                'name' => 'data',
                'type' => 'text',
                'label' => 'Data',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(NotificationMessageRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->addFields([
            [
                'name' => 'to',
                'type' => 'select2',
                'entity' => 'notification_user',
                'attribute' => 'userable_id',
                'label' => 'To'
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Title'
            ],
            [
                'name' => 'body',
                'type' => 'text',
                'label' => 'Body',
            ],
            [
                'name' => 'data',
                'type' => 'textarea',
                'label' => 'Data',
            ],
        ]);
    }

    public function store()
    {
      $response = $this->traitStore();

      // do something after save
      $this->crud->entry->notify(new SendMessageNotification());

      return $response;
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
