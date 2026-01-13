<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
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
         CRUD::column('id');
    CRUD::column('total_amount');
    CRUD::column('status');

    CRUD::addColumn([
        'label'     => 'Address',
        'type'      => 'text',
        'name'      => 'deliveryAddress.address',
    ]);

    CRUD::addColumn([
        'label'     => 'City',
        'type'      => 'text',
        'name'      => 'deliveryAddress.city',
    ]);

    CRUD::addColumn([
        'label'     => 'State',
        'type'      => 'text',
        'name'      => 'deliveryAddress.state',
    ]);

    CRUD::addColumn([
        'label'     => 'Pincode',
        'type'      => 'text',
        'name'      => 'deliveryAddress.pincode',
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
       // CRUD::setValidation(OrderRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
         CRUD::setValidation([
        'user_id' => 'required|exists:users,id',
        'address_id' => 'required|exists:addresses,id',
        'total_amount' => 'required|numeric',
        'status' => 'required|in:pending,completed,cancelled',
        'payment_method' => 'required|in:cod,online',
    ]);

    // User select_from_array
    CRUD::addField([
        'name' => 'user_id',
        'label' => 'User',
        'type' => 'select_from_array',
        'options' => \App\Models\User::pluck('name', 'id')->toArray(),
    ]);

    // Address select_from_array
    CRUD::addField([
        'name' => 'address_id',
        'label' => 'Delivery Address',
        'type' => 'select_from_array',
        'options' => \App\Models\Address::pluck('address', 'id')->toArray(),
    ]);

    // Total amount
    CRUD::addField([
        'name' => 'total_amount',
        'label' => 'Total Amount',
        'type' => 'number',
        'attributes' => ['step' => '0.01'],
    ]);

    // Status
    CRUD::addField([
        'name' => 'status',
        'label' => 'Order Status',
        'type' => 'select_from_array',
        'options' => [
            'pending' => 'Pending',
            'completed' => 'Completed',
            'delivered' => 'Delivered',
        ],
        'default' => 'pending',
    ]);

    // Payment method
    CRUD::addField([
        'name' => 'payment_method',
        'label' => 'Payment Method',
        'type' => 'select_from_array',
        'options' => [
            'cod' => 'Cash on Delivery',
            'online' => 'Online Payment',
        ],
        'default' => 'cod',
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
     protected function setupShowOperation()
{
    CRUD::set('show.view', 'vendor.backpack.crud.order_preview');
}
}
