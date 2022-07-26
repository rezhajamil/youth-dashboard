<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesContoller;
use App\Http\Controllers\DirectUserController;
use App\Http\Controllers\SalesContoller;
use App\Http\Controllers\SekolahController;
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

Route::name('sekolah.')->group(function () {
    Route::post('sekolah/get_kabupaten', [SekolahController::class, 'getKabupaten'])->name('get_kabupaten');
    Route::post('sekolah/get_kecamatan', [SekolahController::class, 'getKecamatan'])->name('get_kecamatan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('direct_sales', DirectSalesContoller::class);
    Route::resource('sales', SalesContoller::class);
    // Route::resource('sekolah', SekolahController::class);
    Route::get('sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::post('sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::delete('sekolah/{npsn}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::put('sekolah/{npsn}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::get('sekolah/{npsn}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::get('sekolah/{npsn}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    // Route::get('sales', function () {
    //     return redirect()->route('sales.migrasi');
    // });
    Route::get('migrasi/sales', [SalesContoller::class, 'migrasi'])->name('sales.migrasi');
    Route::get('orbit/sales', [SalesContoller::class, 'orbit'])->name('sales.orbit');
    Route::resource('direct_user', DirectUserController::class);
    Route::put('direct_user/change_status/{direct_user}', [DirectUserController::class, 'changeStatus'])->name('direct_user.change_status');
});

require __DIR__ . '/auth.php';
