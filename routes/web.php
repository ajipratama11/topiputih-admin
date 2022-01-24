<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\InviteUserController;
use App\Http\Controllers\ProgramPublicController;
use App\Http\Controllers\ProgramPrivateController;
use App\Http\Controllers\SendEmailController;
use App\Models\InvitedUser;

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




Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('login', [LoginController::class, 'index'])->name('login');
// Route::get('/company', [CompanyController::class, 'index'])->middleware('auth');
// Route::get('/company/edit', [CompanyController::class, 'edit'])->middleware('auth');
Route::get('send_email',[SendEmailController::class,'index']);

Route::group(['middleware' => ['admin']], function() {
    Route::get('/', [DashboardController::class,'index']);
    Route::get('dashboard',[DashboardController::class,'index']);
    Route::resource('researcher', ResearcherController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('program_public', ProgramPublicController::class);
    Route::resource('program_private', ProgramPrivateController::class);
    Route::resource('invite_user', InviteUserController::class);
    Route::resource('certificate', CertificateController::class);
    Route::resource('report', ReportController::class);
    Route::get('dashboard',[DashboardController::class,'index']);
});
// Route::resource('/company/edit', CompanyController::class)->middleware('auth');
// Route::get('/researcher', [ResearcherController::class,'index'])->middleware('auth');;




