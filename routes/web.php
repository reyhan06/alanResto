<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/transactions', [ProductController::class, 'index'])->name('transactions');
Route::post('/save', [ProductController::class, 'saveCart'])->name('transactions.save');

Route::resource('products', ProductController::class);
