<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResearcherController;
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


Route::group(['middleware' => ['admin']], function() {
    Route::get('/', [DashboardController::class,'index']);
    Route::get('dashboard',[DashboardController::class,'index']);
    Route::resource('researcher', ResearcherController::class);
    Route::resource('company', CompanyController::class);
});
// Route::resource('/company/edit', CompanyController::class)->middleware('auth');
// Route::get('/researcher', [ResearcherController::class,'index'])->middleware('auth');;




