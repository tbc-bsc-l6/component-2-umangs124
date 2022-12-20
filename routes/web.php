<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// all products
Route::get('/products', [ProductController::class, 'index']);

// Show create form
Route::get('/products/create', [ProductController::class, 'create']);

// Store product data
Route::post('/products', [ProductController::class, 'store']);

/* ----------------------------------------------------- */

// Store user data
Route::post('/users', [UserController::class, 'store']);