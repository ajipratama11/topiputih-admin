<?php

use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\ResearcherBankController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('/register_tes', [UserController::class, 'register_tes']);
Route::post('login_tes', [UserController::class, 'login_tes']);
Route::get('/program', [ProgramController::class, 'index']);
Route::get('/program/{id}', [ProgramController::class, 'show']);
Route::get('/program/search/{name}', [ProgramController::class, 'search']);

Route::post('forgot_password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('reset_password', [ResetPasswordController::class, 'reset']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/program', [ProgramController::class, 'create']);
    Route::post('/update_program', [ProgramController::class, 'update']);
    Route::post('/program_image', [ProgramController::class, 'update_image']);
    Route::delete('/program/{id}', [ProgramController::class, 'delete']);
    Route::get('/program_list/{id}', [ProgramController::class, 'show_list']);

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user',  [UserController::class, 'user']);

    Route::put('/password', [UserController::class, 'edit_password']);
    Route::post('/cek_password', [UserController::class, 'cek_password']);
    Route::post('/edit_password', [UserController::class, 'edit_password']);

    Route::post('/add_bank',[ResearcherBankController::class, 'create']);
    Route::post('/edit_bank',[ResearcherBankController::class, 'update']);
    Route::get('/bank/{user_id}', [ResearcherBankController::class, 'show']);

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/edit_user',[UserController::class, 'edit_user']);
    Route::post('/update_profile',[UserController::class, 'update_profile']);

    Route::get('/cert/{id}/', [CertificateController::class, 'show']);
    Route::post('/upload_cert',[CertificateController::class, 'store']);
    Route::delete('/cert/{id}', [CertificateController::class, 'delete']);
    Route::post('/update_cert',[CertificateController::class, 'update']);
    // Route::get('/cert_detail/{id}/', [CertificateController::class, 'show_detail']);

    Route::get('/cert_keahlian/{user_id}/', [CertificateController::class, 'show_1']);
    Route::get('/cert_penghargaan/{user_id}/', [CertificateController::class, 'show_2']);
});
    

