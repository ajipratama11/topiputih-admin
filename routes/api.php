<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\ResearcherBankController;

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
Route::get('/program_cek/{id}&{user_id}', [ProgramController::class, 'cek_program']);
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

    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report', [ReportController::class, 'create']);
    Route::get('/report/{id}', [ReportController::class, 'show']);
    Route::get('/report_user/{id}', [ReportController::class, 'show_list_user']);
    Route::get('/report_program/{id}', [ReportController::class, 'show_list_program']);

    //invite
   
    Route::post('/insert_user',  [ProgramController::class, 'set_user']);
    Route::delete('/delete_invited/{id}', [ProgramController::class, 'delete_invited']);
   
   
    Route::get('/get_program/{id}',  [ProgramController::class, 'get_user_program']);
    Route::get('send_email/{email}',[SendEmailController::class,'index']);


    
});
Route::get('/point_program/{id}', [PointController::class, 'show_point_program']);
Route::get('/point', [PointController::class, 'index']);

Route::post('/researcher',  [ProgramController::class, 'researcher_program']);
Route::get('/researcher/{id}',  [ProgramController::class, 'get_researcher']);
Route::get('/get_invite/{id}',  [ProgramController::class, 'get_user_invited']);