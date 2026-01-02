<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AuthController extends Controller
{
    public function showRegister()
{
    return view('register');
}

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'is_user' => 0 // default normal user
    ]);

    return redirect('/login')->with('success', 'Registration successful. Please login.');
}
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            if (Auth::user()->is_user == 1) {
                return redirect('/admin/dashboard');
            }

           return redirect()->route('products.index');
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    public function adminDashboard()
    {
        if (!Auth::check() || Auth::user()->is_user != 1) {
            abort(403);
        }
        $totalUsers = User::count();
        $totalAdmins = User::where('is_user', 1)->count();
        $totalNormalUsers = User::where('is_user', 0)->count();

        $pendingOrders   = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalNormalUsers',
            'pendingOrders',
            'confirmedOrders',
            'deliveredOrders',
            'totalRevenue'
        ));
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect('/login');
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
}
