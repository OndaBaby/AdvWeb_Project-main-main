<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/customer-all', 'customer.index');

Route::view('/brand-all', 'brand.index');

Route::view('/courier-all', 'courier.index');

// Route::view('/product-all', 'product.index');

//bawal na pala tong mga to kapag nakapag API na
// Route::resource('suppliers', SupplierController::class);
// Route::resource('brands', BrandController::class);
// Route::resource('products', ProductController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'user'])->name('home');
});

Route::middleware(['auth','role'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
});

Route::view('/supplier', 'supplier.index');
Route::view('/product', 'product.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
