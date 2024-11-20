<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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
    return view('login');
})->name('login');



Route::view('/login', 'login')->name('login-page');
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/categories', [ProductController::class, 'categories'])->name('categories')->middleware('auth:sanctum');
Route::get('/dashboard',[ProductController::class, 'dashboard'])->name('dashboard')->middleware('auth:sanctum');
Route::post('/categories', [ProductController::class, 'store'])->name('categories.store')->middleware('auth');
Route::delete('/categories/{id}', [ProductController::class, 'destroy'])->name('categories.destroy')->middleware('auth');
Route::get('/categories/{id}/edit', [ProductController::class, 'edit'])->name('categories.edit')->middleware('auth');
Route::put('/categories/{id}', [ProductController::class, 'update'])->name('categories.update')->middleware('auth');

Route::post('/products/store', [ProductController::class, 'storeProduct'])->name('product.store')->middleware('auth');
Route::delete('/product/{id}', [ProductController::class, 'destroyProduct'])->name('product.destroy')->middleware('auth');
Route::get('/product/{id}/edit', [ProductController::class, 'editProduct'])->name('product.edit')->middleware('auth');
Route::put('/product/{id}', [ProductController::class, 'updateProduct'])->name('product.update')->middleware('auth');
Route::get('/product', [ProductController::class, 'product'])->name('product')->middleware('auth:sanctum');
Route::get('products/export', [ProductController::class, 'exportToCsv'])->name('products.export');
Route::resource('products', ProductController::class);
Route::get('product/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
Route::get('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
Route::delete('products/{id}/forceDelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');









