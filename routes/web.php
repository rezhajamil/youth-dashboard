<?php

use App\Http\Controllers\BroadCastController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesContoller;
use App\Http\Controllers\DirectUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SalesContoller;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TakerController;
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
    Route::post('wilayah/get_sub_branch', [WilayahController::class, 'getSubBranch'])->name('get_sub_branch');
    Route::post('wilayah/get_cluster', [WilayahController::class, 'getCluster'])->name('get_cluster');
    Route::post('wilayah/get_provinsi', [WilayahController::class, 'getProvinsi'])->name('get_provinsi');
    Route::post('wilayah/get_kabupaten', [WilayahController::class, 'getKabupaten'])->name('get_kabupaten');
    Route::post('wilayah/get_kecamatan', [WilayahController::class, 'getKecamatan'])->name('get_kecamatan');
    Route::post('wilayah/get_kelurahan', [WilayahController::class, 'getKelurahan'])->name('get_kelurahan');
    Route::post('wilayah/get_tap', [WilayahController::class, 'getTap'])->name('get_tap');
});

Route::name('sekolah.')->group(function () {
    Route::post('sekolah/get_kabupaten', [SekolahController::class, 'getKabupaten'])->name('get_kabupaten');
    Route::post('sekolah/get_kecamatan', [SekolahController::class, 'getKecamatan'])->name('get_kecamatan');
});

Route::get('/qns/', [QuizController::class, 'answer'])->name('quiz.answer.create');
Route::get('/start/quiz/', [QuizController::class, 'start'])->name('quiz.answer.start');
Route::get('/answer_list/quiz/{id}', [QuizController::class, 'answer_list'])->name('quiz.answer.list');
Route::post('/store_answer/quiz/', [QuizController::class, 'store_answer'])->name('quiz.answer.store');

Route::get('/qns/survey', [SurveyController::class, 'answer'])->name('survey.answer.create');
Route::get('/qns/survey/lucky_draw', [SurveyController::class, 'lucky_draw'])->name('survey.lucky_draw');
Route::post('/qns/survey/telp_list', [SurveyController::class, 'telp_list'])->name('survey.telp_list');
Route::get('/start/survey/', [SurveyController::class, 'start'])->name('survey.answer.start');
Route::get('/resume/survey/{id}', [SurveyController::class, 'resume'])->name('survey.answer.resume');
Route::get('/answer_list/survey', [SurveyController::class, 'answer_list'])->name('survey.answer.list');
Route::post('/store_answer/survey/', [SurveyController::class, 'store_answer'])->name('survey.answer.store');

Route::post('/find_school', [SurveyController::class, 'find_school']);
Route::post('/find_school_pjp', [SekolahController::class, 'find_school']);

Route::middleware(['cors'])->group(function () {
    Route::get('/test', [SurveyController::class, 'test']);
    Route::post('/taker/segment2', [TakerController::class, 'segment2']);
    Route::post('/taker/non_usim', [TakerController::class, 'non_usim']);
});

//Must Login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('direct_sales', DirectSalesContoller::class);
    Route::resource('sales', SalesContoller::class);
    Route::resource('broadcast', BroadCastController::class);
    Route::resource('outlet', OutletController::class);
    Route::get('call', [BroadCastController::class, 'broadcast_call'])->name('broadcast.call');

    Route::get('campaign', [BroadCastController::class, 'campaign'])->name('campaign.index');
    Route::post('campaign', [BroadCastController::class, 'store_campaign'])->name('campaign.store');
    Route::get('campaign/create', [BroadCastController::class, 'create_campaign'])->name('campaign.create');
    Route::delete('campaign/{id}', [BroadCastController::class, 'destroy_campaign'])->name('campaign.destroy');
    Route::resource('outlet', OutletController::class);

    Route::get('whitelist', [BroadCastController::class, 'whitelist'])->name('whitelist.index');
    Route::post('whitelist', [BroadCastController::class, 'store_whitelist'])->name('whitelist.store');
    Route::get('whitelist/create', [BroadCastController::class, 'create_whitelist'])->name('whitelist.create');
    Route::delete('whitelist/{id}', [BroadCastController::class, 'destroy_whitelist'])->name('whitelist.destroy');
    Route::put('whitelist/{telp}', [BroadCastController::class, 'release_whitelist'])->name('whitelist.release');
    Route::get('whitelist/distribusi', [BroadCastController::class, 'create_whitelist_distribusi'])->name('whitelist.distribusi.create');
    Route::post('whitelist/distribusi', [BroadCastController::class, 'store_whitelist_distribusi'])->name('whitelist.distribusi.store');
    Route::get('whitelist/distribusi/user', [BroadCastController::class, 'get_user_distribusi'])->name('whitelist.distribusi.user');

    Route::get('sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::post('sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::delete('sekolah/{npsn}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::put('sekolah/{npsn}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::get('sekolah/{npsn}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::get('sekolah/{npsn}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::get('resume/sekolah', [SekolahController::class, 'resume'])->name('sekolah.resume');
    Route::get('oss_osk/sekolah', [SekolahController::class, 'oss_osk'])->name('sekolah.oss_osk');
    Route::get('pjp/sekolah', [SekolahController::class, 'pjp'])->name('sekolah.pjp');
    Route::get('pjp/sekolah/create', [SekolahController::class, 'create_pjp'])->name('sekolah.pjp.create');
    Route::post('pjp/sekolah/store', [SekolahController::class, 'store_pjp'])->name('sekolah.pjp.store');
    Route::get('pjp/sekolah/user', [SekolahController::class, 'get_user_pjp'])->name('sekolah.pjp.user');

    Route::get('content/sapaan', [ContentController::class, 'sapaan'])->name('sapaan.index');
    Route::post('content/sapaan', [ContentController::class, 'store_sapaan'])->name('sapaan.store');
    Route::get('content/sapaan/create', [ContentController::class, 'create_sapaan'])->name('sapaan.create');
    Route::delete('content/sapaan/{id}', [ContentController::class, 'destroy_sapaan'])->name('sapaan.destroy');

    Route::get('content/challenge', [ContentController::class, 'challenge'])->name('challenge.index');
    Route::post('content/challenge', [ContentController::class, 'store_challenge'])->name('challenge.store');
    Route::get('content/challenge/create', [ContentController::class, 'create_challenge'])->name('challenge.create');
    Route::delete('content/challenge/{id}', [ContentController::class, 'destroy_challenge'])->name('challenge.destroy');

    Route::get('content/slide', [ContentController::class, 'slide'])->name('slide.index');
    Route::post('content/slide', [ContentController::class, 'store_slide'])->name('slide.store');
    Route::get('content/slide/create', [ContentController::class, 'create_slide'])->name('slide.create');
    Route::delete('content/slide/{id}', [ContentController::class, 'destroy_slide'])->name('slide.destroy');

    Route::get('content/schedule', [ContentController::class, 'schedule'])->name('schedule.index');
    Route::post('content/schedule', [ContentController::class, 'store_schedule'])->name('schedule.store');
    Route::get('content/schedule/create', [ContentController::class, 'create_schedule'])->name('schedule.create');
    Route::delete('content/schedule/{id}', [ContentController::class, 'destroy_schedule'])->name('schedule.destroy');
    Route::put('content/schedule/{id}', [ContentController::class, 'change_status_schedule'])->name('schedule.change_status');

    Route::get('content/notification', [ContentController::class, 'notification'])->name('notification.index');
    Route::post('content/notification', [ContentController::class, 'store_notification'])->name('notification.store');
    Route::get('content/notification/create', [ContentController::class, 'create_notification'])->name('notification.create');
    Route::delete('content/notification/{id}', [ContentController::class, 'destroy_notification'])->name('notification.destroy');

    Route::get('content/category', [ContentController::class, 'category'])->name('category.index');
    Route::post('content/category', [ContentController::class, 'store_category'])->name('category.store');
    Route::get('content/category/create', [ContentController::class, 'create_category'])->name('category.create');
    Route::delete('content/category/{id}', [ContentController::class, 'destroy_category'])->name('category.destroy');

    Route::get('content/news', [ContentController::class, 'news'])->name('news.index');
    Route::post('content/news', [ContentController::class, 'store_news'])->name('news.store');
    Route::get('content/news/create', [ContentController::class, 'create_news'])->name('news.create');
    Route::delete('content/news/{id}', [ContentController::class, 'destroy_news'])->name('news.destroy');
    // Route::get('sales', function () {
    //     return redirect()->route('sales.migrasi');
    // });
    Route::get('migrasi/sales', [SalesContoller::class, 'migrasi'])->name('sales.migrasi');
    Route::get('orbit/sales', [SalesContoller::class, 'orbit'])->name('sales.orbit');
    Route::delete('orbit/sales/destroy/{msisdn}', [SalesContoller::class, 'destroy_orbit'])->name('sales.orbit.destroy');
    Route::get('digipos/sales', [SalesContoller::class, 'digipos'])->name('sales.digipos');

    Route::get("location/taps", [LocationController::class, 'taps'])->name('location.taps');
    Route::get("location/taps/create", [LocationController::class, 'create_taps'])->name('location.taps.create');
    Route::get("location/taps/edit/{id}", [LocationController::class, 'edit_taps'])->name('location.taps.edit');
    Route::put("location/taps/update/{id}", [LocationController::class, 'update_taps'])->name('location.taps.update');
    Route::post("location/taps/post", [LocationController::class, 'store_taps'])->name('location.taps.store');
    Route::get("location/poi", [LocationController::class, 'poi'])->name('location.poi');
    Route::get("location/poi/create", [LocationController::class, 'create_poi'])->name('location.poi.create');
    Route::post("location/poi/post", [LocationController::class, 'store_poi'])->name('location.poi.store');
    Route::get("location/poi/edit/{id}", [LocationController::class, 'edit_poi'])->name('location.poi.edit');
    Route::put("location/poi/update/{id}", [LocationController::class, 'update_poi'])->name('location.poi.update');

    Route::resource('direct_user', DirectUserController::class);
    Route::put('direct_user/change_status/{direct_user}', [DirectUserController::class, 'changeStatus'])->name('direct_user.change_status');
    Route::get('absensi', [DirectUserController::class, 'absensi'])->name('direct_user.absensi');
    Route::get('absensi/show/{telp}', [DirectUserController::class, 'show_absensi'])->name('direct_user.absensi.show');

    Route::resource('event', EventController::class);
    Route::get('resume/event', [EventController::class, 'resume'])->name('event.resume');
    Route::get('layak/event/{id}', [EventController::class, 'layak'])->name('event.layak');
    Route::post('keterangan/event', [EventController::class, 'add_keterangan'])->name('event.keterangan');
    Route::get('absen/event', [EventController::class, 'absen'])->name('event.absen');
    Route::get('create/absen/event', [EventController::class, 'create_absen'])->name('event.absen.create');
    Route::post('store/absen/event', [EventController::class, 'store_absen'])->name('event.absen.store');
    Route::get('challenge/event', [EventController::class, 'challenge'])->name('event.challenge');
    Route::get('poin_history/event', [EventController::class, 'poin_history'])->name('event.poin_history');
    Route::get('challenge/approve/event/{id}', [EventController::class, 'approve'])->name('event.approve');
    Route::get('challenge/status/event/{id}', [EventController::class, 'challenge_status'])->name('event.challenge_status');
    Route::post('challenge/keterangan/event', [EventController::class, 'add_keterangan_challenge'])->name('event.keterangan_challenge');

    Route::resource('quiz', QuizController::class);
    Route::resource('survey', SurveyController::class);
    Route::get('/show_answer/quiz/{id}', [QuizController::class, 'show_answer'])->name('quiz.show_answer');
    Route::get('/show_answer/survey/{id}', [SurveyController::class, 'show_answer'])->name('survey.show_answer');

    Route::put('/change_status/quiz/{id}', [QuizController::class, 'change_status'])->name('quiz.change_status');
    Route::put('/change_status/survey/{id}', [SurveyController::class, 'change_status'])->name('survey.change_status');
});

require __DIR__ . '/auth.php';
