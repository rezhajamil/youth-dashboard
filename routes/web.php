<?php

use App\Http\Controllers\BroadCastController;
use App\Http\Controllers\ByuController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesContoller;
use App\Http\Controllers\DirectUserController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SalesContoller;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TakerController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\TravelController;
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
    Route::post('wilayah/get_lbo_city', [WilayahController::class, 'getLboCity'])->name('get_lbo_city');
});

Route::name('sekolah.')->group(function () {
    Route::post('sekolah/get_kabupaten', [SekolahController::class, 'getKabupaten'])->name('get_kabupaten');
    Route::post('sekolah/get_kecamatan', [SekolahController::class, 'getKecamatan'])->name('get_kecamatan');
});


Route::get('/qns', [QuizController::class, 'answer'])->name('quiz.answer.create');
Route::get('/start/quiz/', [QuizController::class, 'start'])->name('quiz.answer.start');
Route::get('/answer_list/quiz/{id}', [QuizController::class, 'answer_list'])->name('quiz.answer.list');
Route::post('/store_answer/quiz/', [QuizController::class, 'store_answer'])->name('quiz.answer.store');

Route::get('/qns/survey/{url}', [SurveyController::class, 'answer'])->name('survey.answer.create');
Route::get('/qns/lucky_draw', [SurveyController::class, 'lucky_draw'])->name('survey.lucky_draw');
Route::post('/qns/survey/telp_list', [SurveyController::class, 'telp_list'])->name('survey.telp_list');
Route::get("/qns/survey/operator_percent/{url}", [SurveyController::class, 'get_operator_percentage'])->name('survey.operator_percentage');
Route::get('/start/survey/{url}', [SurveyController::class, 'start'])->name('survey.answer.start');
Route::get('/resume/survey/{id}', [SurveyController::class, 'resume'])->name('survey.answer.resume');
Route::get('/answer_list/survey', [SurveyController::class, 'answer_list'])->name('survey.answer.list');
Route::post('/store_answer/survey/', [SurveyController::class, 'store_answer'])->name('survey.answer.store');
Route::get('/resume_territory/survey/{survey}', [SurveyController::class, 'resume_territory'])->name('survey.resume_territory');
Route::get('fb_share', [SurveyController::class, 'fb_share'])->name('survey.fb_share');
Route::get('fb_share/detail', [SurveyController::class, 'fb_share_detail'])->name('survey.fb_share_detail');

Route::get('travel/create', [SurveyController::class, 'create_travel'])->name('survey.create_travel');
Route::post('travel/store', [SurveyController::class, 'store_travel'])->name('survey.store_travel');
// Route::get('/qns/{url}', [SurveyController::class, 'redirect_survey'])->name('survey.redirect');


Route::get('/get_resume_school', [SurveyController::class, 'get_resume_school']);
Route::get('/find_school', [SurveyController::class, 'find_school']);
Route::post('/find_school_pjp', [SekolahController::class, 'find_school']);

Route::get('sales/get_location', [SalesContoller::class, 'getLocation'])->name('sales.get_location');
Route::get('tradein', [SalesContoller::class, 'getRefferal'])->name('sales.get_refferal');
Route::post('store_refferal', [SalesContoller::class, 'storeRefferal'])->name('sales.store_refferal');

Route::middleware(['cors'])->group(function () {
    Route::get('/test', [SurveyController::class, 'test']);
    Route::post('/taker/segment2', [TakerController::class, 'segment2']);
    Route::post('/taker/non_usim', [TakerController::class, 'non_usim']);

    Route::get('/resume_api', [DashboardController::class, 'resume_api']);
    Route::post('/taker/digipos', [TakerController::class, 'digipos']);

    Route::get('kpi_api', [DirectUserController::class, 'kpi_api'])->name('direct_user.kpi_api');
    Route::get('kpi_yba_api', [DirectUserController::class, 'kpi_yba_api'])->name('direct_user.kpi_yba_api');
});

//Must Login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
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

    Route::get('whitelist', [BroadCastController::class, 'whitelist'])->name('whitelist.index');
    Route::post('whitelist', [BroadCastController::class, 'store_whitelist'])->name('whitelist.store');
    Route::get('whitelist/create', [BroadCastController::class, 'create_whitelist'])->name('whitelist.create');
    Route::delete('whitelist/{id}', [BroadCastController::class, 'destroy_whitelist'])->name('whitelist.destroy');
    Route::put('whitelist/{telp}', [BroadCastController::class, 'release_whitelist'])->name('whitelist.release');
    Route::get('whitelist/distribusi', [BroadCastController::class, 'create_whitelist_distribusi'])->name('whitelist.distribusi.create');
    Route::post('whitelist/distribusi', [BroadCastController::class, 'store_whitelist_distribusi'])->name('whitelist.distribusi.store');
    Route::get('whitelist/distribusi/user', [BroadCastController::class, 'get_user_distribusi'])->name('whitelist.distribusi.user');

    Route::get('sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
    Route::get('sekolah/favorit', [SekolahController::class, 'favorit'])->name('sekolah.favorit');
    Route::post('sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
    Route::get('sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::delete('sekolah/{npsn}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    Route::put('sekolah/{npsn}', [SekolahController::class, 'update'])->name('sekolah.update');
    Route::put('sekolah/update_favorite/{npsn}', [SekolahController::class, 'update_favorit'])->name('sekolah.update_favorit');
    Route::get('sekolah/{npsn}', [SekolahController::class, 'show'])->name('sekolah.show');
    Route::get('sekolah/{npsn}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::get('resume/sekolah', [SekolahController::class, 'resume'])->name('sekolah.resume');
    Route::get('oss_osk/sekolah', [SekolahController::class, 'oss_osk'])->name('sekolah.oss_osk');
    Route::delete('oss_osk/sekolah/destroy/{id}', [SekolahController::class, 'destroy_oss_osk'])->name('sekolah.oss_osk.destroy');
    Route::get('pjp/sekolah', [SekolahController::class, 'pjp'])->name('sekolah.pjp');
    Route::get('pjp/sekolah/create', [SekolahController::class, 'create_pjp'])->name('sekolah.pjp.create');
    Route::post('pjp/sekolah/store', [SekolahController::class, 'store_pjp'])->name('sekolah.pjp.store');
    Route::get('pjp/sekolah/edit/{id}', [SekolahController::class, 'edit_pjp'])->name('sekolah.pjp.edit');
    Route::put('pjp/sekolah/update/{id}', [SekolahController::class, 'update_pjp'])->name('sekolah.pjp.update');
    Route::delete('pjp/sekolah/destroy/{id}', [SekolahController::class, 'destroy_pjp'])->name('sekolah.pjp.destroy');
    Route::get('pjp/sekolah/user', [SekolahController::class, 'get_user_pjp'])->name('sekolah.pjp.user');
    Route::get('pjp/sekolah/poi', [SekolahController::class, 'get_poi'])->name('sekolah.pjp.poi');
    Route::get('pjp/sekolah/site', [SekolahController::class, 'get_site'])->name('sekolah.pjp.site');
    Route::get('pjp/sekolah/site_acq', [SekolahController::class, 'get_site_acq'])->name('sekolah.pjp.site_acq');
    Route::get('pjp/sekolah/outlet', [SekolahController::class, 'get_outlet'])->name('sekolah.pjp.outlet');

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

    Route::get('download', [DownloadController::class, 'index'])->name('download.index');
    Route::get('download/csv', [DownloadController::class, 'downloadCsv'])->name('download.csv');
    Route::get('content/dokumen', [ContentController::class, 'dokumen'])->name('dokumen.index');
    Route::post('content/dokumen', [ContentController::class, 'store_dokumen'])->name('dokumen.store');
    Route::get('content/dokumen/create', [ContentController::class, 'create_dokumen'])->name('dokumen.create');
    Route::delete('content/dokumen/{id}', [ContentController::class, 'destroy_dokumen'])->name('dokumen.destroy');
    // Route::get('sales', function () {
    //     return redirect()->route('sales.migrasi');
    // });
    Route::get('migrasi/sales', [SalesContoller::class, 'migrasi'])->name('sales.migrasi');
    Route::get('orbit/sales', [SalesContoller::class, 'orbit'])->name('sales.orbit');
    Route::delete('orbit/sales/destroy/{msisdn}', [SalesContoller::class, 'destroy_orbit'])->name('sales.orbit.destroy');
    Route::get('orbit_digipos/sales', [SalesContoller::class, 'orbit_digipos'])->name('sales.orbit_digipos');
    Route::delete('orbit_digipos/sales/destroy/{msisdn}', [SalesContoller::class, 'destroy_orbit_digipos'])->name('sales.orbit_digipos.destroy');
    Route::delete('product/sales/destroy/{msisdn}', [SalesContoller::class, 'destroy_product'])->name('sales.product.destroy');
    Route::get('digipos/sales', [SalesContoller::class, 'digipos'])->name('sales.digipos');
    Route::get('product/sales', [SalesContoller::class, 'product'])->name('sales.product');
    Route::get('location/sales', [SalesContoller::class, 'location'])->name('sales.location');
    Route::get('/product/sales/export', [SalesContoller::class, 'exportProduct']);
    Route::get('trade_in/sales', [SalesContoller::class, 'tradeInBuddies'])->name('sales.trade_in.index');

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

    Route::get("location/site", [LocationController::class, 'site'])->name('location.site');
    Route::get("location/site/create", [LocationController::class, 'create_site'])->name('location.site.create');
    Route::post("location/site/post", [LocationController::class, 'store_site'])->name('location.site.store');
    Route::get("location/site/edit/{id}", [LocationController::class, 'edit_site'])->name('location.site.edit');
    Route::get("location/site/show/{id}", [LocationController::class, 'show_site'])->name('location.site.show');
    Route::put("location/site/update/{id}", [LocationController::class, 'update_site'])->name('location.site.update');

    Route::resource('direct_user', DirectUserController::class);
    Route::put('direct_user/change_status/{direct_user}', [DirectUserController::class, 'changeStatus'])->name('direct_user.change_status');
    Route::get('absensi', [DirectUserController::class, 'absensi'])->name('direct_user.absensi');
    Route::get('absensi/show/{telp}', [DirectUserController::class, 'show_absensi'])->name('direct_user.absensi.show');
    Route::get('clock_in', [DirectUserController::class, 'clock_in'])->name('direct_user.clock_in');
    Route::get('resume_clock_in', [DirectUserController::class, 'resume_clock_in'])->name('direct_user.resume_clock_in');
    Route::get('monthly_clock_in', [DirectUserController::class, 'monthly_clock_in'])->name('direct_user.monthly_clock_in');
    Route::get('kpi_old', [DirectUserController::class, 'kpi_old'])->name('direct_user.kpi_old');
    Route::get('resume_kpi_old', [DirectUserController::class, 'resume_kpi_old'])->name('direct_user.resume_kpi_old');
    Route::get('kpi', [DirectUserController::class, 'kpi'])->name('direct_user.kpi');
    Route::get('resume_kpi', [DirectUserController::class, 'resume_kpi'])->name('direct_user.resume_kpi');
    Route::get('kpi_yba', [DirectUserController::class, 'kpi_yba'])->name('direct_user.kpi_yba');

    Route::resource('event', EventController::class);
    Route::get('create_peserta_sekolah', [EventController::class, 'create_peserta_sekolah'])->name('event.create_peserta_sekolah');
    Route::post('store_peserta_sekolah', [EventController::class, 'store_peserta_sekolah'])->name('event.store_peserta_sekolah');
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

    Route::resource('byu', ByuController::class);
    Route::get('byu/report/create', [ByuController::class, 'create_report'])->name('byu.report.create');
    Route::post('byu/report/store', [ByuController::class, 'store_report'])->name('byu.report.store');
    Route::get('byu/distribusi/create', [ByuController::class, 'create_distribusi'])->name('byu.distribusi.create');
    Route::post('byu/distribusi/store', [ByuController::class, 'store_distribusi'])->name('byu.distribusi.store');
    Route::get('byu/distribusi/view', [ByuController::class, 'view_distribusi'])->name('byu.distribusi.view');
    Route::get('byu/stok/view', [ByuController::class, 'view_stok'])->name('byu.stok.view');
    Route::get('byu/report/view', [ByuController::class, 'view_report'])->name('byu.report.view');
    Route::post('byu/get_outlet', [ByuController::class, 'get_outlet'])->name('byu.get_outlet');
    Route::post('byu/get_max_input', [ByuController::class, 'get_max_input'])->name('byu.get_max_input');

    Route::resource('sertifikat', CertificateController::class);

    Route::get('travel', [TravelController::class, 'index'])->name('travel.index');
    Route::get('travel/create', [TravelController::class, 'create'])->name('travel.create');
    Route::get('travel/edit/{id}', [TravelController::class, 'edit'])->name('travel.edit');
    Route::get('travel/keberangkatan', [TravelController::class, 'keberangkatan'])->name('travel.keberangkatan');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/thread.php';
