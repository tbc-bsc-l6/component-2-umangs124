<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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
Route::get('showAllVendors', [UserController::class, 'index'])->middleware('auth');

// Show create form for users
Route::get('showCreateVendorForm', [UserController::class, 'create'])->middleware('auth');

// Store user data by admin
Route::post('createVendor', [UserController::class, 'store'])->middleware('auth');

// show edit form for users for admin
Route::get('showEditVendorForm/{vendor}', [UserController::class, 'edit'])->middleware('auth');

// update user by admin
Route::put('updateVendor/{vendors}', [UserController::class, 'update'])->middleware('auth');

// delete user by admin
Route::delete('deleteVendor/{vendors}', [UserController::class, 'destroy'])->middleware('auth');

Route::get('showChangePasswordForm', [UserController::class, 'showChangePasswordForm'])->middleware('auth');
Route::post('changePassword', [UserController::class, 'changePassword']);
Route::post('sendVerificationCode', [UserController::class, 'sendVerificationCode'])->middleware('auth');

Route::get('verificationCodeForm', [UserController::class, 'verificationCodeForm'])->middleware('auth');
Route::post('verifyVerificationCode', [UserController::class, 'verifyVerificationCode'])->middleware('auth');


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
Route::get('showCreateProductForm', [ProductController::class, 'create'])->middleware('auth');
Route::get('/', [ProductController::class, 'index']);
Route::get('showProductByVendorId', [ProductController::class, 'show'])->middleware('auth');
Route::get('showEditProductForm/{product}', [ProductController::class, 'edit'])->middleware('auth');
Route::put('updateProduct/{product}', [ProductController::class, 'update'])->middleware('auth');
Route::post('createProduct', [ProductController::class, 'store'])->middleware('auth');
Route::delete('deleteProduct/{products}', [ProductController::class, 'destroy'])->middleware('auth');
