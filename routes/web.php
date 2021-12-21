<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PenelitiController;
use App\Http\Controllers\ProgramPublikController;
use App\Http\Controllers\ProgramPrivateController;
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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard',[DashboardController::class,'index']);
Route::get('/perusahaan', [PerusahaanController::class, 'index']);
Route::get('/peneliti', [PenelitiController::class, 'index']);
Route::get('/program-publik', [ProgramPublikController::class, 'index']);
Route::get('/program-private', [ProgramPrivateController::class, 'index']);
