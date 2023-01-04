<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
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
Route::get('showAllVendors', [AdminController::class, 'index']);

// Show create form for users
Route::get('showCreateVendorForm', [AdminController::class, 'create']);

// Store user data by admin
Route::post('createVendor', [AdminController::class, 'store']);

// show edit form for users for admin
Route::get('showEditVendorForm/{vendor}', [AdminController::class, 'edit']);

// update user by admin
Route::put('updateVendor/{vendors}', [AdminController::class, 'update']);

// delete user by admin
Route::delete('deleteVendor/{vendors}', [AdminController::class, 'destroy']);



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