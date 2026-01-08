<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductQuestionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductQuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductQuestionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ProductQuestion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product-question');
        CRUD::setEntityNameStrings('product question', 'product questions');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
         CRUD::denyAccess('create');
         
        // USER NAME COLUMN
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
         CRUD::addColumn([
        'name' => 'question',
        'label' => 'Question',
        'type' => 'textarea',
        'limit' => 80,
    ]);

    CRUD::addColumn([
        'name' => 'answer',
        'label' => 'Answer',
        'type' => 'textarea',
        'limit' => 80,
    ]);

    CRUD::addColumn([
        'name' => 'answered',
        'label' => 'Answered',
        'type' => 'boolean',
    ]);


         
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductQuestionRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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
       // $this->setupCreateOperation();
       CRUD::addField([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'select',
            'entity' => 'user',
            'model' => \App\Models\User::class,
            'attribute' => 'name',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);
        CRUD::addField([
            'name' => 'user_email',
            'label' => 'Email',
            'type' => 'text',
            'value' => $this->crud->getCurrentEntry()->user->email ?? '', 
            'attributes' => [
                'readonly' => 'readonly', 
                'class' => 'form-control',
            ],
        ]);

        CRUD::addField([
            'name' => 'product_id',
            'label' => 'Product',
            'type' => 'select',
            'entity' => 'product', 
            'model' => \App\Models\Product::class,
            'attribute' => 'name',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);
        CRUD::addField([
        'name' => 'question',
        'label' => 'Question',
        'type' => 'textarea',
        'attributes' => [
            'readonly' => 'readonly',
        ],
        ]);
        CRUD::addField([
            'name' => 'answer',
            'label' => 'Answer',
            'type' => 'textarea',
        ]);

    }
}
