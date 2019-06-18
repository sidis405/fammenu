<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\CrudPanel;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DishCrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\DishCrudRequest as UpdateRequest;

/**
 * Class DishCrudControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DishCrudControllerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Dish');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/dishes');
        $this->crud->setEntityNameStrings('dish', 'dishes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addField([  // Select2
           'label' => "Type",
           'type' => 'select2',
           'name' => 'dish_type_id',
           'entity' => 'type',
           'attribute' => 'name',
           'model' => "App\DishType",
           'wrapperAttributes' => ['class' => 'col-md-4']
        ]);

        $this->crud->addField([  // Select2
           'label' => "Restaurant",
           'type' => 'select2',
           'name' => 'restaurant_id',
           'entity' => 'restaurant',
           'attribute' => 'name',
           'model' => "App\Restaurant",
           'wrapperAttributes' => ['class' => 'col-md-4']
        ]);

        $this->crud->addField([  // Select2
           'label' => "User",
           'type' => 'select2',
           'name' => 'user_id',
           'entity' => 'user',
           'attribute' => 'name',
           'model' => "App\User",
           'wrapperAttributes' => ['class' => 'col-md-4']
        ]);

        $this->crud->addColumn([
           'label' => "Restaurant", // Table column heading
           'type' => "select",
           'name' => 'restaurant_id', // the column that contains the ID of that connected entity;
           'entity' => 'restaurant', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Restaurant",
        ]);

        $this->crud->addColumn([
           'label' => "User", // Table column heading
           'type' => "select",
           'name' => 'user_id', // the column that contains the ID of that connected entity;
           'entity' => 'user', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\User", // foreign key model
        ]);

        $this->crud->addColumn([
           'label' => "Type", // Table column heading
           'type' => "select",
           'name' => 'dish_type_id', // the column that contains the ID of that connected entity;
           'entity' => 'type', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\DishType", // foreign key model
        ]);

        // add asterisk for fields that are required in DishCrudControllerRequest
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
