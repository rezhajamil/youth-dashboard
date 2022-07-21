<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesContoller;
use App\Http\Controllers\DirectUserController;
use App\Http\Controllers\SalesContoller;
use App\Http\Controllers\WilayahController;
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

Route::name('wilayah.')->group(function () {
    Route::get('wilayah/get_region', [WilayahController::class, 'getRegion'])->name('get_region');
    Route::post('wilayah/get_branch', [WilayahController::class, 'getBranch'])->name('get_branch');
    Route::post('wilayah/get_cluster', [WilayahController::class, 'getCluster'])->name('get_cluster');
    Route::post('wilayah/get_tap', [WilayahController::class, 'getTap'])->name('get_tap');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('direct_sales', DirectSalesContoller::class);
    Route::resource('sales', SalesContoller::class);
    // Route::get('sales', function () {
    //     return redirect()->route('sales.migrasi');
    // });
    Route::get('migrasi/sales', [SalesContoller::class, 'migrasi'])->name('sales.migrasi');
    Route::get('orbit/sales', [SalesContoller::class, 'orbit'])->name('sales.orbit');
    Route::resource('direct_user', DirectUserController::class);
    Route::put('direct_user/change_status/{direct_user}', [DirectUserController::class, 'changeStatus'])->name('direct_user.change_status');
});

require __DIR__ . '/auth.php';
