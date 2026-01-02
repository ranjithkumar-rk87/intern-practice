<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $detail = $user->detail;

        return view('user.profile', compact('user', 'detail'));
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
}

