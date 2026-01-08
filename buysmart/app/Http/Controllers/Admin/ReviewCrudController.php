<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ReviewRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ReviewCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReviewCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Review::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/review');
        CRUD::setEntityNameStrings('review', 'reviews');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
       // CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
                CRUD::addColumn([
            'name' => 'user.name',
            'label' => 'User Name',
            'type' => 'text',
        ]);

        // USER EMAIL COLUMN
        CRUD::addColumn([
            'name' => 'user.email',
            'label' => 'User Email',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'product.name',
            'label' => 'Product',
            'type' => 'text',
        ]);
          CRUD::column('rating');
        CRUD::column('review');
        CRUD::column('created_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
       // CRUD::setValidation(ReviewRequest::class);
       // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
         CRUD::setValidation(ReviewRequest::class);

        CRUD::field('user_id')
            ->type('select')
            ->label('User')
            ->entity('user')
            ->model('App\Models\User')
            ->attribute('name');

        CRUD::field('product_id')
            ->type('select')
            ->label('Product')
            ->entity('product')
            ->model('App\Models\Product')
            ->attribute('name');

        CRUD::field('rating')->type('number')->attributes(["min" => 1, "max" => 5]);
        CRUD::field('review')->type('textarea');
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
