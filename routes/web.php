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
Route::get('showAllVendors', [UserController::class, 'index']);

// Show create form for users
Route::get('showCreateVendorForm', [UserController::class, 'create']);

// Store user data by admin
Route::post('createVendor', [UserController::class, 'store']);

// show edit form for users for admin
Route::get('showEditVendorForm/{vendor}', [UserController::class, 'edit']);

// update user by admin
Route::put('updateVendor/{vendors}', [UserController::class, 'update']);

// delete user by admin
Route::delete('deleteVendor/{vendors}', [UserController::class, 'destroy']);

Route::get('showChangePasswordForm', [UserController::class, 'showChangePasswordForm']);
Route::post('changePassword', [UserController::class, 'changePassword']);
Route::post('sendVerificationCode', [UserController::class, 'sendVerificationCode']);

Route::get('verificationCodeForm', [UserController::class, 'verificationCodeForm']);
Route::post('verifyVerificationCode', [UserController::class, 'verifyVerificationCode']);


/*
|--------------------------------------------------------------------------
| Routes for Authentication
|--------------------------------------------------------------------------
*/
Route::get('users/showRegisterForm', [AuthController::class, 'register']);
Route::get('users/showLoginForm', [AuthController::class, 'login']);
Route::post('users/register', [AuthController::class, 'store']);
Route::post('users/login', [AuthController::class, 'authenticate']);
Route::post('users/logout', [AuthController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| Routes for Products
|--------------------------------------------------------------------------
*/
Route::get('showCreateProductForm', [ProductController::class, 'create']);
Route::get('/', [ProductController::class, 'index']);
Route::get('showProductByVendorId', [ProductController::class, 'show']);
Route::get('showEditProductForm/{product}', [ProductController::class, 'edit']);
Route::put('updateProduct/{product}', [ProductController::class, 'update']);
Route::post('createProduct', [ProductController::class, 'store']);
Route::delete('deleteProduct/{products}', [ProductController::class, 'destroy']);
