<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
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

        CRUD::addColumn(['name' => 'id', 'type' => 'number', 'label' => 'Order ID']);

        CRUD::addColumn([
            'name' => 'user_name',
            'label' => 'User Name',
            'type' => 'closure',
            'function' => function ($entry) {
                return optional($entry->user)->name ?? '-';
            },
            'escaped' => false,
        ]);

        CRUD::addColumn([
            'name' => 'user_email',
            'label' => 'Email',
            'type' => 'closure',
            'function' => function ($entry) {
                return optional($entry->user)->email ?? '-';
            },
            'escaped' => false,
        ]);


        CRUD::addColumn(['name' => 'total_amount', 'type' => 'number', 'suffix' => ' ₹']);

        CRUD::addColumn(['name' => 'status', 'type' => 'text']);




        CRUD::denyAccess('create');

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
protected function setupCreateOperation()
{
    // Validation rules
    CRUD::setValidation([
        'user_id' => 'required|exists:users,id',
        'status' => 'required|in:pending,confirmed,delivered',
        'product' => 'required|exists:products,id',
        'qty' => 'required|numeric|min:1',
        'address' => 'required|string|max:500',
        'phone' => 'required|string|max:20',
        'city' => 'required|string|max:50',
        'state' => 'required|string|max:50',
        'pincode' => 'required|string|max:10',
    ]);

    // Customer selection
    CRUD::addField([
        'name' => 'user_id',
        'type' => 'select',
        'entity' => 'user',
        'attribute' => 'name',
        'model' => "App\Models\User",
        'label' => 'Customer',
    ]);

    // Status
    CRUD::addField([
        'name' => 'status',
        'type' => 'select_from_array',
        'options' => [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'delivered' => 'Delivered',
        ],
        'label' => 'Status',
    ]);

    // Product
    CRUD::addField([
        'name' => 'product',
        'type' => 'select',
        'label' => 'Product',
        'model' => 'App\Models\Product',
        'attribute' => 'name',
        'options' => function ($query) {
            return $query->orderBy('name')->get();
        },
    ]);

    // Quantity
    CRUD::addField([
        'name' => 'qty',
        'type' => 'number',
        'label' => 'Quantity',
        'attributes' => ['min' => 1],
        'value' => 1,
    ]);

    // User details fields
    CRUD::addField([
        'name' => 'address',
        'type' => 'textarea',
        'label' => 'Address',
        'attributes' => ['rows' => 2, 'placeholder' => 'Enter shipping address'],
    ]);

    CRUD::addField([
        'name' => 'phone',
        'type' => 'text',
        'label' => 'Phone',
    ]);

    CRUD::addField([
        'name' => 'city',
        'type' => 'text',
        'label' => 'City',
    ]);

    CRUD::addField([
        'name' => 'state',
        'type' => 'text',
        'label' => 'State',
    ]);

    CRUD::addField([
        'name' => 'pincode',
        'type' => 'text',
        'label' => 'Pincode',
    ]);

    // Total amount
    CRUD::addField([
        'name' => 'total_amount',
        'type' => 'number',
        'label' => 'Total Amount',
        'attributes' => ['step' => '0.01'],
        'value' => 0,
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
         CRUD::setValidation([
            'user_id' => 'required|exists:users,id',
            
            'status' => 'required|in:pending,confirmed,delivered',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,delivered',
        ]);
        CRUD::addField([
            'name' => 'user_id',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\User",
            'label' => 'Customer',
        ]);

        CRUD::addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'delivered' => 'Delivered'
            ],
            'label' => 'Status',
        ]);
    
        CRUD::addField([
            'name' => 'product',
            'type' => 'select',
            'label' => 'Product',
            'model' => 'App\Models\Product',
            'attribute' => 'name',
            'options' => function ($query) {
                return $query->orderBy('name')->get();
            },
            'value' => optional($this->crud->getCurrentEntry()->items->first())->product_id ?? null,
        ]);


        CRUD::addField([
            'name' => 'qty',
            'type' => 'number',
            'label' => 'Quantity',
            'attributes' => ['min' => 1],
            'value' => optional($this->crud->getCurrentEntry()->items->get(0))->quantity ?? 1,
        ]);

        CRUD::addField([
            'name' => 'price',
            'type' => 'number',
            'label' => 'Price',
            'attributes' => ['step' => '0.01'],
            'value' => optional($this->crud->getCurrentEntry()->items->get(0))->price ?? 0,
        ]);
        CRUD::addField([
        'name' => 'total_amount',
        'type' => 'number',
        'label' => 'Total Amount',
        'attributes' => [
            'step' => '0.01',
        ],
         ]);
         // Phone
        CRUD::addField([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone',
            'value' => optional($this->crud->getCurrentEntry()->user->detail)->phone ?? '',
        ]);

        // Address
        CRUD::addField([
            'name' => 'address',
            'type' => 'textarea',
            'label' => 'Address',
            'value' => optional($this->crud->getCurrentEntry()->user->detail)->address ?? '',
        ]);

        // City
        CRUD::addField([
            'name' => 'city',
            'type' => 'text',
            'label' => 'City',
            'value' => optional($this->crud->getCurrentEntry()->user->detail)->city ?? '',
        ]);

        // State
        CRUD::addField([
            'name' => 'state',
            'type' => 'text',
            'label' => 'State',
            'value' => optional($this->crud->getCurrentEntry()->user->detail)->state ?? '',
        ]);

        // Pincode
        CRUD::addField([
            'name' => 'pincode',
            'type' => 'text',
            'label' => 'Pincode',
            'value' => optional($this->crud->getCurrentEntry()->user->detail)->pincode ?? '',
        ]);

    
    }
    protected function setupShowOperation()
{
    CRUD::set('show.view', 'vendor.backpack.crud.order_preview');
}
public function update(Request $request)
{
    $data = $request->all();

    // Update main order
    $order = $this->crud->getCurrentEntry();
    $order->user_id = $data['user_id'];
    $order->status = $data['status'];

    // Get selected product price
    $product = \App\Models\Product::find($data['product']);
    $price = $product ? $product->price : 0;

    // Update first item
    $item = $order->items()->first();
    if ($item) {
        $item->product_id = $data['product'];
        $item->quantity = $data['qty'];
        $item->price = $price;
        $item->save();
    }

    $order->total_amount = $price * $data['qty'];
    $order->save();

    $userDetail = $order->user->detail ?? new \App\Models\UserDetail(['user_id' => $order->user_id]);

    $userDetail->phone   = $data['phone'] ?? $userDetail->phone;
    $userDetail->address = $data['address'] ?? $userDetail->address;
    $userDetail->city    = $data['city'] ?? $userDetail->city;
    $userDetail->state   = $data['state'] ?? $userDetail->state;
    $userDetail->pincode = $data['pincode'] ?? $userDetail->pincode;

    $userDetail->save();

    \Alert::success('Order details updated successfully')->flash();

    return redirect($this->crud->route);
}
public function store(Request $request)
{
    $data = $request->all();

    // Create the order
    $order = new \App\Models\Order();
    $order->user_id = $data['user_id'];
    $order->status = $data['status'];
    $order->total_amount = 0;
    $order->save();

    // Create the first order item
    $product = \App\Models\Product::find($data['product']);
    $price = $product ? $product->price : 0;

    $order->items()->create([
        'product_id' => $data['product'],
        'quantity' => $data['qty'],
        'price' => $price,
    ]);

    // Update total amount
    $order->total_amount = $price * $data['qty'];
    $order->save();

    // Update or create user details
    $userDetail = $order->user->detail ?? new \App\Models\UserDetail(['user_id' => $order->user_id]);
    $userDetail->address = $data['address'];
    $userDetail->phone = $data['phone'];
    $userDetail->city = $data['city'];
    $userDetail->state = $data['state'];
    $userDetail->pincode = $data['pincode'];
    $userDetail->save();

    \Alert::success('Order created successfully')->flash();
    return redirect($this->crud->route);
}





}
