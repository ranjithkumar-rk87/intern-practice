<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');


Route::middleware('guest')->group(function() {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/changepassword', function () {
    return view('changepassword');
})->middleware('auth');

Route::post('/changepassword', [AuthController::class, 'changepassword'])->name('changepassword');

Route::put('/user/edit/{id}', [AuthController::class, 'editUser'])->name('editUser');
Route::delete('/user/delete/{id}', [AuthController::class, 'deleteUser'])->name('user.delete');

Route::post('/upload-image', [AuthController::class, 'upload'])->name('image.upload');
