<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\InviteUserController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProgramActiveController;
use App\Http\Controllers\ProgramPublicController;
use App\Http\Controllers\BalanceCompanyController;
use App\Http\Controllers\PaymentProgramController;
use App\Http\Controllers\ProgramPrivateController;
use App\Http\Controllers\PaymentResearcherController;
use App\Http\Controllers\PointController as ControllersPointController;
use App\Http\Controllers\ReportDelayController;
use App\Http\Controllers\UserController;

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
// Route::get('/', function () {
//     return view('welcome');
// });




Route::post('/masuk', [LoginController::class, 'authenticate']);
Route::post('/keluar', [LoginController::class, 'logout']);

Route::get('masuk', [LoginController::class, 'index'])->name('masuk');
// Route::get('/company', [CompanyController::class, 'index'])->middleware('auth');
// Route::get('/company/edit', [CompanyController::class, 'edit'])->middleware('auth');
Route::get('kirim_email',[SendEmailController::class,'index']);

Route::group(['middleware' => ['admin']], function() {
    Route::get('/', [DashboardController::class,'index']);
    Route::get('halaman-utama',[DashboardController::class,'index']);
    Route::resource('pengguna', UserController::class);
    Route::resource('peneliti-keamanan', ResearcherController::class);
    Route::resource('pemilik-sistem', CompanyController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('program-publik', ProgramPublicController::class);
    Route::resource('program-privat', ProgramPrivateController::class);
    Route::resource('program-berjalan', ProgramActiveController::class);
    Route::resource('undang-peneliti', InviteUserController::class);
    Route::resource('sertifikat', CertificateController::class);
    Route::resource('laporan', ReportController::class);
    Route::resource('laporan-menunggu', ReportDelayController::class);
    Route::resource('pembayaran-pemilik-sistem', PaymentController::class);
    Route::resource('keuangan-pemilik-sistem', BalanceCompanyController::class);
    Route::resource('pembayaran-peneliti-keamanan', PaymentProgramController::class);
    Route::resource('keuangan-peneliti-keamanan', PaymentResearcherController::class);
    Route::resource('skor', PointController::class);
    // Route::get('dashboard',[DashboardController::class,'index']);
    Route::get('pencarian/{id}',[InviteUserController::class,'search']);
    Route::get('daftar/{id}',[InviteUserController::class,'list']);
    Route::post('ubah-category/{$id}', [ReportController::class, 'change_category']);
});
// Route::resource('/company/edit', CompanyController::class)->middleware('auth');
// Route::get('/researcher', [ResearcherController::class,'index'])->middleware('auth');;




