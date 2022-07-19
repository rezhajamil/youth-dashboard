<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesContoller;
use App\Http\Controllers\SalesContoller;
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


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('direct_sales', DirectSalesContoller::class);
    Route::resource('sales', SalesContoller::class);
});

require __DIR__ . '/auth.php';
