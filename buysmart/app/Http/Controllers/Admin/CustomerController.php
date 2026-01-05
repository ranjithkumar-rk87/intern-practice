<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{
    public function index()
    {
      if (!Auth::check() || !Auth::user()->hasRole('admin')) {
        abort(403, 'Unauthorized');
    }


        $users = User::latest()->get();

        return view('admin.customer', compact('users'));
    }
    public function create()
    {
        return view('admin.createcustomer');
    } 
        public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|digits:10',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string',
            'state'    => 'nullable|string',
            'pincode'  => 'nullable|string',
        ]);

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');


        // Create user detail
        $user->detail()->create([
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
            'pincode' => $request->pincode,
        ]);

        return redirect()->route('listcustomer')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.editcustomer', compact('user'));
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,

        'phone'    => 'nullable|digits:10',
        'address'  => 'nullable|string',
        'city'     => 'nullable|string',
        'state'    => 'nullable|string',
        'pincode'  => 'nullable|digits:6',

        'role' => 'required|in:admin,user'
    ]);

    $data = $request->only('name','email');

    $user->update($data);

      if (auth()->id() != $user->id) {
        $user->syncRoles([$request->role]);
    }

    UserDetail::updateOrCreate(
        ['user_id' => $user->id],
        $request->only('phone', 'address', 'city', 'state', 'pincode')
    );

    return redirect()->route('listcustomer')->with('success','User updated');
}
   public function destroy($id)
{
        $user = User::findOrFail($id);
        $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully');
}
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('admin')) {
            return back()->with('error', 'User is already an admin');
        }

        $user->removeRole('user');
        $user->assignRole('admin');

        return back()->with('success', 'User promoted to Admin successfully');
    }

    public function removeAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->removeRole('admin');
        $user->assignRole('user');

        return back()->with('success', 'Admin changed to User');
    }
}
