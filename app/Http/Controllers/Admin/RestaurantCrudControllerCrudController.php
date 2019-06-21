<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\CrudPanel;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\RestaurantCrudRequest as StoreRequest;
use App\Http\Requests\RestaurantCrudRequest as UpdateRequest;

/**
 * Class RestaurantCrudControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RestaurantCrudControllerCrudController extends CrudController
{
    public function setup()
    {
        if (! backpack_user()->hasPermissionTo('Manage Restaurants', 'web')) {
            $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);
        }
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Restaurant');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/restaurants');
        $this->crud->setEntityNameStrings('restaurant', 'restaurants');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Hosts",
            'type' => 'select2_multiple',
            'name' => 'hosts', // the method that defines the relationship in your Model
            'entity' => 'hosts', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\BackpackUser", // foreign key model
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get()->map(function ($user) {
                    return $user->hasRole('Host') ? $user : null;
                })->reject(function ($null) {
                    return ! $null;
                });
            }),
            'pivot' => true,
        ]);

        // add asterisk for fields that are required in RestaurantCrudControllerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
