<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Backpack\CRUD\CrudPanel;
use App\Http\Requests\MenuCrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\MenuCrudRequest as UpdateRequest;

/**
 * Class MenuCrudControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MenuCrudControllerCrudController extends CrudController
{
    public function setup()
    {
        if (! backpack_user()->hasPermissionTo('Manage Menus', 'web')) {
            $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);
        }
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Menu');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/menus');
        $this->crud->setEntityNameStrings('menu', 'menus');

        $restaurants = backpack_user()->restaurants->pluck('id')->values()->toArray();

        $this->crud->addClause('whereIn', 'restaurant_id', $restaurants);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->removeFields(['user_id', 'cal']);
        // $this->crud->removeColumns([]);


        $this->crud->addField([  // Select2
           'label' => "Restaurant",
           'type' => 'select2',
           'name' => 'restaurant_id',
           'entity' => 'restaurant',
           'attribute' => 'name',
           'model' => "App\Restaurant",
           'options'   => (function ($query) {
               return $query->whereHas('hosts', function ($query) {
                   $query->where('user_id', backpack_user()->id);
               })->get();
           }),
           'wrapperAttributes' => [
               'class' => 'col-md-6'
           ]
        ]);

        $this->crud->addField([   // DateTime
            'name' => 'start_at',
            'label' => 'Start',
            'type' => 'datetime_picker',
            'default' => now(),
            'wrapperAttributes' => [
                // 'class' => 'col-md-6'
            ]
        ]);

        $this->crud->addField([   // DateTime
            'name' => 'end_at',
            'label' => 'End',
            'type' => 'datetime_picker',
            'default' => now()->addWeeks(1),
            'wrapperAttributes' => [
                // 'class' => 'col-md-6'
            ]
        ]);

        $this->crud->addField([   // Number
            'name' => 'price',
            'label' => 'Price',
            'type' => 'number',
            // optionals
            // 'attributes' => ["step" => "any"], // allow decimals
            'prefix' => "€",
            // 'suffix' => ".00",
            'wrapperAttributes' => [
                'class' => 'col-md-6'
            ]
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Dishes",
            'type' => 'select2_multiple',
            'name' => 'dishes', // the method that defines the relationship in your Model
            'entity' => 'dishes', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Dish", // foreign key model
            'pivot' => true,
            'options'   => (function ($query) {
                return $query->where('restaurant_id', Menu::find(request()->segment(3))->restaurant_id)->get();
            }),
        ], 'update');

        $this->crud->addColumn([
           'label' => "Restaurant", // Table column heading
           'type' => "select",
           'name' => 'restaurant_id', // the column that contains the ID of that connected entity;
           'entity' => 'restaurant', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Restaurant", // foreign key model
        ]);

        $this->crud->addColumn([
           'label' => "User", // Table column heading
           'type' => "select",
           'name' => 'user_id', // the column that contains the ID of that connected entity;
           'entity' => 'user', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\User", // foreign key model
        ]);

        // $this->crud->addColumn([
        //    'label' => "Cal", // Table column heading
        //    'type' => "text",
        //    'name' => 'total_cal',
        // ]);

        // $this->crud->addColumn([
        //    // n-n relationship (with pivot table)
        //    'label' => "Dishes", // Table column heading
        //    'type' => "select_multiple",
        //    'name' => 'dishes', // the method that defines the relationship in your Model
        //    'entity' => 'dishes', // the method that defines the relationship in your Model
        //    'attribute' => "name", // foreign key attribute that is shown to user
        //    'model' => "App\Dish", // foreign key model
        // ]);

        $this->crud->addFilter([ // select2 filter
          'name' => 'restaurant_id',
          'type' => 'select2',
          'label'=> 'Restaurant'
        ], function () {
            return \App\Restaurant::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'restaurant_id', $value);
        });

        $this->crud->addFilter([ // select2 filter
          'name' => 'user_id',
          'type' => 'select2',
          'label'=> 'User'
        ], function () {
            return \App\User::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'user_id', $value);
        });

        $this->crud->addFilter(
            [
          'name' => 'cal_range',
          'type' => 'range',
          'label'=> 'Filter Cal',
          'label_from' => 'min',
          'label_to' => 'max'
        ],
        false,
        function ($value) { // if the filter is active
            $range = json_decode($value);
            if ($range->from) {
                $this->crud->addClause('where', 'cal', '>=', (float) $range->from);
            }
            if ($range->to) {
                $this->crud->addClause('where', 'cal', '<=', (float) $range->to);
            }
        }
        );

        $this->crud->enableExportButtons();

        // add asterisk for fields that are required in MenuCrudControllerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $this->crud->entry->updateCal();

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $this->crud->entry->updateCal();

        return $redirect_location;
    }
}
