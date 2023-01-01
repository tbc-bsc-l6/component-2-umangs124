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
// All users
Route::get('/users', [UserController::class, 'index']);

// Show create form for users
Route::get('/users/create', [UserController::class, 'create']);

// Store user data
Route::post('/users', [UserController::class, 'store']);

// show edit form for users
Route::get('/users/{users}/edit', [UserController::class, 'edit']);

// update user
Route::put('/users/{users}', [UserController::class, 'update']);

// delete user
Route::delete('/users/{users}', [UserController::class, 'destroy']);
