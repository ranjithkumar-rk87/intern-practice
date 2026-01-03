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
        if (!Auth::check() || Auth::user()->is_user != 1) {
            abort(403, 'Unauthorized');
        }

        $users = User::where('is_user', 0)->latest()->get();

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
            'is_user'  => 0,
        ]);

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
        'is_user'  => 'required|in:0,1',

        'phone'    => 'nullable|digits:10',
        'address'  => 'nullable|string',
        'city'     => 'nullable|string',
        'state'    => 'nullable|string',
        'pincode'  => 'nullable|digits:6',
    ]);

    $data = $request->only('name','email','is_user');

    $user->update($data);

    UserDetail::updateOrCreate(
        ['user_id' => $user->id],
        $request->only('phone', 'address', 'city', 'state', 'pincode')
    );

    return redirect()->route('admindashboard')->with('success','User updated');
}
   public function destroy($id)
{
        $user = User::findOrFail($id);
        $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully');
}

}
