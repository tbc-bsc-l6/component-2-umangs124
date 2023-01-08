<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductHistoryController;
use App\Http\Controllers\ProductTypeController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Routes for Admin
|--------------------------------------------------------------------------
*/
// show All users for admin
Route::get('showAllVendors', [UserController::class, 'index'])->middleware('admin');

// Show create form for users
Route::get('showCreateVendorForm', [UserController::class, 'create'])->middleware('admin');

// Store user data by admin
Route::post('createVendor', [UserController::class, 'store'])->middleware('admin');

// show edit form for users for admin
Route::get('showEditVendorForm/{vendor}', [UserController::class, 'edit'])->middleware('admin');

// update user by admin
Route::put('updateVendor/{vendors}', [UserController::class, 'update'])->middleware('admin');

// delete user by admin
Route::delete('deleteVendor/{vendors}', [UserController::class, 'destroy'])->middleware('admin');

Route::get('showChangePasswordForm', [UserController::class, 'showChangePasswordForm'])->middleware('vendor');
Route::post('changePassword', [UserController::class, 'changePassword']);
Route::post('sendVerificationCode', [UserController::class, 'sendVerificationCode'])->middleware('vendor');

Route::get('verificationCodeForm', [UserController::class, 'verificationCodeForm'])->middleware('vendor');
Route::post('verifyVerificationCode', [UserController::class, 'verifyVerificationCode'])->middleware('vendor');

Route::get('showProductHistories', [ProductHistoryController::class, 'index'])->middleware('admin');
Route::delete('deleteProductHistories/{productHistories}', [ProductHistoryController::class, 'destroy'])->middleware('admin');

// Product Type
Route::get('showProductTypes', [ProductTypeController::class, 'index']);
Route::get('productTypeCreateForm', [ProductTypeController::class, 'create']);
Route::post('addProductType', [ProductTypeController::class, 'store']);
Route::delete('deleteProductType/{productType}', [ProductTypeController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Routes for Authentication
|--------------------------------------------------------------------------
*/
Route::get('users/showRegisterForm', [AuthController::class, 'register'])->middleware('guest');
Route::get('users/showLoginForm', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('users/register', [AuthController::class, 'store'])->middleware('guest');
Route::post('users/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::post('users/logout', [AuthController::class, 'logout'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| Routes for Products
|--------------------------------------------------------------------------
*/
Route::get('showCreateProductForm', [ProductController::class, 'create'])->middleware('vendor');
Route::get('/', [ProductController::class, 'index']);
Route::get('showProductByVendorId/{vendors}', [ProductController::class, 'show'])->middleware('auth');
Route::get('showEditProductForm/{product}', [ProductController::class, 'edit'])->middleware('vendor');
Route::put('updateProduct/{product}', [ProductController::class, 'update'])->middleware('vendor');
Route::post('createProduct', [ProductController::class, 'store'])->middleware('vendor');
Route::delete('deleteProduct/{products}', [ProductController::class, 'destroy'])->middleware('vendor');
