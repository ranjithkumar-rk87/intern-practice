<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view('register');
    }
     public function showLogin(){
        return view('login');
    }
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
            'token'   => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Optional: revoke old tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;
        return redirect('/dashboard');
        // return response()->json([
        //     'message' => 'Login successful',
        //     'user'    => $user,
        //     'token'   => $token,
        //     'token_type' => 'Bearer',
        // ]);
    }

    // DASHBOARD / PROFILE (Protected)
    public function dashboard(Request $request)
    {
        $users = User::all();
        return view('dashboard', compact('users'));
        // return response()->json([
        //     'message' => 'Welcome to dashboard',
        //     'user'    => $request->user(),
        // ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
       // $request->user()->currentAccessToken()->delete();

        // return response()->json([
        //     'message' => 'Logged out successfully'
        // ]);
        Auth::logout();

        return redirect('/login');

    }

    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/dashboard')->with('success', 'User deleted successfully!');

    }
    
    public function changepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }
    public function upload(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $image = $request->file('image');
        $name = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs('images', $name, 'public');

        return back()->with('image_success', 'Image uploaded successfully!');
}


}
