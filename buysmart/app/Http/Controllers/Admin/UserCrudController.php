<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\User;
use App\Models\UserDetail;
use Spatie\Permission\Models\Role;
/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        #CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
            // Name column
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        // Email column
        CRUD::addColumn([
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
        ]);

        // Role column (show first role of user or multiple roles)
        CRUD::addColumn([
            'name' => 'roles',
            'type' => 'closure',
            'label' => 'Role',
            'function' => function ($entry) {
                // If multiple roles, join names with comma
                return $entry->roles->pluck('name')->implode(', ') ?: 'User';
            }
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

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::setValidation([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);

        CRUD::addField([
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
        ]);

        CRUD::addField([
            'name' => 'password',
            'type' => 'password',
            'label' => 'Password',
        ]);
        CRUD::addField([
            'name' => 'password_confirmation',
            'type' => 'password',
            'label' => 'Confirm Password',
         ]);

        CRUD::addField([
            'label' => 'Role',
            'type' => 'select',
            'name' => 'role_id', 
            'entity' => 'roles',
            'attribute' => 'name',
            'model' => "Spatie\Permission\Models\Role",
        ]);

         $user = $this->crud->getCurrentEntry();

        CRUD::addField([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone',
            'value' => $user ? optional($user->detail)->phone : '',
        ]);

        CRUD::addField([
            'name' => 'address',
            'type' => 'text',
            'label' => 'Address',
            'value' => $user ? optional($user->detail)->address : '',
        ]);

        CRUD::addField([
            'name' => 'city',
            'type' => 'text',
            'label' => 'City',
            'value' => $user ? optional($user->detail)->city : '',
        ]);

        CRUD::addField([
            'name' => 'state',
            'type' => 'text',
            'label' => 'State',
            'value' => $user ? optional($user->detail)->state : '',
        ]);

        CRUD::addField([
            'name' => 'pincode',
            'type' => 'text',
            'label' => 'Pincode',
            'value' => $user ? optional($user->detail)->pincode : '',
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
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . CRUD::getCurrentEntryId(),
    ]);

    CRUD::addField([
        'name' => 'name',
        'type' => 'text',
    ]);

    CRUD::addField([
        'name' => 'email',
        'type' => 'email',
    ]);
    CRUD::addField([
            'label'     => 'Roles',
            'type'      => 'select_multiple',
            'name'      => 'roles',
            'entity'    => 'roles',
            'attribute' => 'name',
            'model'     => Role::class,
            'pivot'     => true,
        ]);

    
    $user = $this->crud->getCurrentEntry();
    CRUD::addField([
        'name' => 'phone',
        'type' => 'text',
        'label' => 'Phone',
        'value' => optional($user->detail)->phone ?? '',
    ]);
    CRUD::addField([
        'name' => 'address',
        'type' => 'text',
        'label' => 'Address',
        'value' => optional($user->detail)->address ?? '',
    ]);
    CRUD::addField([
        'name' => 'city',
        'type' => 'text',
        'label' => 'City',
        'value' => optional($user->detail)->city ?? '',
    ]);
    CRUD::addField([
        'name' => 'state',
        'type' => 'text',
        'label' => 'State',
        'value' => optional($user->detail)->state ?? '',
    ]);
    CRUD::addField([
        'name' => 'pincode',
        'type' => 'text',
        'label' => 'Pincode',
         'value' => optional($user->detail)->pincode ?? '',
    ]);
    }
 public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $data = $this->crud->getRequest()->except(['phone','address','city','state','pincode','password_confirmation']);
        $user = User::create($data);

        // Assign roles if any
        if (request()->has('roles')) {
            $user->syncRoles(request('roles'));
        }

        // Save UserDetail
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $this->crud->getRequest()->only(['phone','address','city','state','pincode'])
        );

        return redirect()->to($this->crud->route);
    }

    // Override update to handle UserDetail
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        $user = $this->crud->getEntry($this->crud->getCurrentEntryId());

        $data = $this->crud->getRequest()->except(['phone','address','city','state','pincode','password_confirmation']);
        if (empty($data['password'])) {
            unset($data['password']); // don't overwrite if empty
        }

        $user->update($data);

         if (request()->has('roles')) {
            $roleNames = Role::whereIn('id', request('roles'))
                ->pluck('name')
                ->toArray();

            $user->syncRoles($roleNames);
        }

        // Save UserDetail
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $this->crud->getRequest()->only(['phone','address','city','state','pincode'])
        );

        return redirect()->to($this->crud->route);
    }
}
