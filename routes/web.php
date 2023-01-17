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

// show All vendors
Route::get('showAllVendors', [UserController::class, 'index'])->middleware('admin');

// Show create form for vendor to admin
Route::get('showCreateVendorForm', [UserController::class, 'create'])->middleware('admin');

// Store vendor data
Route::post('createVendor', [UserController::class, 'store'])->middleware('admin');

// show edit form for vendor
Route::get('showEditVendorForm/{vendor}', [UserController::class, 'edit'])->middleware('admin');

// update vendor
Route::put('updateVendor/{vendors}', [UserController::class, 'update'])->middleware('admin');

// delete vendor
Route::delete('deleteVendor/{vendors}', [UserController::class, 'destroy'])->middleware('admin');

// show change password form
Route::get('showChangePasswordForm', [UserController::class, 'showChangePasswordForm'])->middleware('vendor');

// store password
Route::post('changePassword', [UserController::class, 'changePassword']);

// send verification code to email
Route::post('sendVerificationCode', [UserController::class, 'sendVerificationCode'])->middleware('vendor');

// show verification code form
Route::get('verificationCodeForm', [UserController::class, 'verificationCodeForm'])->middleware('vendor');

// verify verification code 
Route::post('verifyVerificationCode', [UserController::class, 'verifyVerificationCode'])->middleware('vendor');

// show product histories
Route::get('showProductHistories', [ProductHistoryController::class, 'index'])->middleware('admin');

// delete product histories
Route::delete('deleteProductHistories/{productHistories}', [ProductHistoryController::class, 'destroy'])->middleware('admin');

// show all product types
Route::get('showProductTypes', [ProductTypeController::class, 'index']);

// show product type form
Route::get('productTypeCreateForm', [ProductTypeController::class, 'create']);

// store product type
Route::post('addProductType', [ProductTypeController::class, 'store']);

// delete product type
Route::delete('deleteProductType/{productType}', [ProductTypeController::class, 'destroy']);

// show register form
Route::get('users/showRegisterForm', [AuthController::class, 'register'])->middleware('guest');

// show login form
Route::get('users/showLoginForm', [AuthController::class, 'login'])->name('login')->middleware('guest');

// store user(Admin/Vendor)
Route::post('users/register', [AuthController::class, 'store'])->middleware('guest');

// authenticate user
Route::post('users/login', [AuthController::class, 'authenticate'])->middleware('guest');

// log out user
Route::post('users/logout', [AuthController::class, 'logout'])->middleware('auth');

// show create product form
Route::get('showCreateProductForm', [ProductController::class, 'create'])->middleware('vendor');

// all products
Route::get('/', [ProductController::class, 'index']);

// show products by vendor id
Route::get('showProductByVendorId/{vendors}', [ProductController::class, 'show'])->middleware('auth');

// show edit product form 
Route::get('showEditProductForm/{product}', [ProductController::class, 'edit'])->middleware('vendor');

// update product
Route::put('updateProduct/{product}', [ProductController::class, 'update'])->middleware('vendor');

// show create product form
Route::post('createProduct', [ProductController::class, 'store'])->middleware('vendor');

// delete product
Route::delete('deleteProduct/{products}', [ProductController::class, 'destroy'])->middleware('vendor');
