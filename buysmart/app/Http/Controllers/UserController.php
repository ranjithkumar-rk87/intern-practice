<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $detail = $user->detail;
        $addresses = $user->addresses()->orderByDesc('is_default')->get();

        return view('user.profile', compact('user', 'detail','addresses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|digits:10',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'pincode' => 'nullable|digits:6',
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only('phone', 'address', 'city', 'state', 'pincode')
        );

        return back()->with('success', 'Profile updated successfully');
    }
    public function editAddress(Address $address)
    {

        return view('user.address_edit', compact('address'));
    }
     public function updateAddress(Request $request, Address $address)
    {

        $request->validate([
            'full_name' => 'required|string|max:100',
            'phone'     => 'required|digits:10',
            'address'   => 'required|string|max:255',
            'city'      => 'required|string|max:100',
            'state'     => 'required|string|max:100',
            'pincode'   => 'required|digits:6',
        ]);

        $isDefault = $request->has('is_default');

        if ($isDefault) {
            $address->user->addresses()->update(['is_default' => false]);
        }

        $address->update(array_merge(
            $request->only(['full_name', 'phone', 'address', 'city', 'state', 'pincode']),
            ['is_default' => $isDefault]
        ));

        return redirect()->route('profile.edit')->with('success', 'Address updated successfully');
    }

    public function destroyAddress(Address $address)
    {

        $address->delete();

        return back()->with('success', 'Address deleted successfully');
    }
     public function setDefaultAddress(Address $address)
    {

        $user = Auth::user();
        $user->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated');
    }
public function storeAddress(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:100',
        'phone'     => 'required|digits:10',
        'address'   => 'required|string|max:255',
        'city'      => 'required|string|max:100',
        'state'     => 'required|string|max:100',
        'pincode'   => 'required|digits:6',
    ]);

    $isDefault = $request->has('is_default');

       if ($isDefault) {
        Auth::user()->addresses()->update(['is_default' => false]);
    }

    // Create address
    Auth::user()->addresses()->create([
        'full_name' => $request->full_name,
        'phone'     => $request->phone,
        'address'   => $request->address,
        'city'      => $request->city,
        'state'     => $request->state,
        'pincode'   => $request->pincode,
        'is_default'=> $isDefault,
    ]);

    return redirect()->route('profile.edit')->with('success', 'Address added successfully.');
}



}

