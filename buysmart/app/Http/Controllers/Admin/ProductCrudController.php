<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
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
            'name' => 'image',
            'label' => 'Product Image',
            'type' => 'closure',
            'function' => function ($entry) {
                if ($entry->image) {
                    return '<img src="'.asset('storage/'.$entry->image).'" height="60" width="60" style="object-fit:cover;">';
                }
                return '-';
            },
            'escaped' => false,
        ]);


        CRUD::addColumn([
            'name' => 'name',
            'label'=>'Product Name',
            'type' => 'text',
        ]);
         CRUD::addColumn([
            'name' => 'category_name',
            'label' => 'Category',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'price',
            'type' => 'number',
            'suffix' => ' ₹',
        ]);

       CRUD::addColumn([
            'name' => 'stock',
            'label' => 'Stock',
            'type' => 'closure',
            'function' => function ($entry) {
                if ($entry->stock == 0) {
                    return '<span class="badge bg-danger text-white">Out of Stock</span>';
                }

                return '<span class="badge bg-success">'.$entry->stock.'</span>';
            },
            'escaped' => false,
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
        // CRUD::setValidation(ProductRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        CRUD::setValidation([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Product Name',
        ]);
           CRUD::addField([
            'name' => 'category_name',
            'type' => 'text',
            'label' => 'Category Name',
        ]);

        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea',
            'label' => 'Description',
        ]);

        CRUD::addField([
            'name' => 'price',
            'type' => 'number',
            'attributes' => [
                'step' => '0.01',
            ],
        ]);

        CRUD::addField([
            'name' => 'stock',
            'type' => 'number',
        ]);

        CRUD::addField([
            'name' => 'image',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'public',
            'label' => 'Product Image',
        ]);

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
