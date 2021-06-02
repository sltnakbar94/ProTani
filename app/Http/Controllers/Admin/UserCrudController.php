<?php

namespace App\Http\Controllers\Admin;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;

class UserCrudController extends BackpackUserCrudController
{
    // protected function setupListOperation()
    // {
    //     $this->crud->removeButton('delete');
    //     $this->crud->setFromDB();
    // }
    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'tab'   => 'Profile',
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
                'attributes' => [
                    'required' => true,
                ]
            ],
            [
                'tab'   => 'Profile',
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
                'attributes' => [
                    'required' => true,
                ]
            ],
            [
                'tab'   => 'Profile',
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
                'attributes' => [
                    'required' => true,
                ]
            ],
            [
                'tab'   => 'Profile',
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'attributes' => [
                    'required' => true,
                ]
            ],
            [
                'tab'   => 'Profile',
                'name'  => 'phone',
                'label' => 'Phone Number',
                'type'  => 'number',
                'attributes' => [
                    'required' => true,
                ]
            ],
            [
                'tab'               => 'Profile',
                // two interconnected entities
                'label'             => 'Roles',
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => '',
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => '',
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }
}
