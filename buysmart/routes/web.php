<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductQuestionController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/address/create', function() {return view('user.address_create');})->name('address.create');
    Route::post('/address/store', [UserController::class, 'storeAddress'])->name('address.store');
    Route::get('/address/{address}/edit', [UserController::class, 'editAddress'])->name('address.edit');
    Route::put('/address/{address}', [UserController::class, 'updateAddress'])->name('address.update');
    Route::delete('/address/{address}', [UserController::class, 'destroyAddress'])->name('address.destroy');
    Route::get('/address/{address}/default', [UserController::class, 'setDefaultAddress'])->name('address.default');
});
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{product}/review', [ProductController::class, 'storeReview'])->name('product.review.store');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware('auth','role:admin')->group(function () {
Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'productList'])->name('admin.products.list');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});

Route::middleware('auth')->group(function () {
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'cartList'])->name('cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'updateQty'])->name('cart.update');

});


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');;
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', [AuthController::class, 'showForgotForm']) ->name('forgot.password.form');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgetpassword');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');


 Route::post('/address/save', [DeliveryController::class, 'saveAddress'])->name('address.save');

Route::middleware('auth')->group(function () {
                                    // change /admin/dashboard
Route::middleware('role:admin')->get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admindashboard');
});

Route::get('/logout', [AuthController::class, 'logout']);
Route::middleware('auth')->group(function () {
Route::post('/change-password', [AuthController::class, 'changepassword'])
        ->name('changepassword');
});
Route::get('/change-password', function () {
    return view('user.changepassword');
})->middleware('auth')->name('password.form');

Route::middleware('auth','role:admin')->group(function () {

Route::get('/customer', [CustomerController::class, 'index'])->name('listcustomer');
Route::post('/users/store', [CustomerController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [CustomerController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [CustomerController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [CustomerController::class, 'destroy'])->name('users.destroy');
Route::get('/users/create', [CustomerController::class, 'create'])->name('users.create');

Route::post('/admin/make-admin/{id}', [CustomerController::class, 'makeAdmin'])->name('make.admin');
Route::post('/admin/remove-admin/{id}', [CustomerController::class, 'removeAdmin'])->name('remove.admin');
});

Route::middleware('auth','role:user')->group(function () {

Route::get('/orders/{id}', [OrderController::class, 'usershow'])->name('orders.show');
Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/place-order', [OrderController::class, 'placeorder'])->name('checkout.place');
Route::get('/buy-now/{id}', [OrderController::class, 'buyNow'])->name('buy.now');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/quantity/{product}', [OrderController::class, 'updateQty'])->name('quantity.update');
Route::get('/orderstatus', [OrderController::class, 'orderStatus'])->name('orderstatus');
});

Route::middleware('auth','role:admin')->group(function () {

Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin//orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
Route::delete('/admin/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
});

Route::middleware('auth')->group(function () {

Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
});


Route::post('/delivery-check/{product}', [DeliveryController::class, 'check'])->name('delivery.check');


Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/questions', [ProductQuestionController::class, 'store'])
        ->name('product.question.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/questions/{question}/answer', [ProductQuestionController::class, 'answer'])
        ->name('product.question.answer');
});
