<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\PaymentController;
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
//login
Route::post('/register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('/register_tes', [UserController::class, 'register_tes']);
Route::post('login_tes', [UserController::class, 'login_tes']);
//program
Route::get('/program', [ProgramController::class, 'index_bb']);
Route::get('/program_vd', [ProgramController::class, 'index_vd']);
Route::get('/program/{id}', [ProgramController::class, 'show']);
Route::get('/program_cek/{id}&{user_id}', [ProgramController::class, 'cek_program']);
Route::get('/program/search/{name}', [ProgramController::class, 'search']);
//reser password
Route::post('forgot_password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('reset_password', [ResetPasswordController::class, 'reset']);
//point
Route::get('/point_program/{id}', [PointController::class, 'show_point_program']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //program
    Route::post('/program', [ProgramController::class, 'create']);
    Route::post('/update_program', [ProgramController::class, 'update']);
    Route::post('/program_image', [ProgramController::class, 'update_image']);
    Route::delete('/program/{id}', [ProgramController::class, 'delete']);
    Route::get('/program_list/{id}', [ProgramController::class, 'show_list']);
    Route::get('/program_private', [ProgramController::class, 'index_vd']);
    Route::get('/get_reward/{id}', [ProgramController::class, 'get_reward']);

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user',  [UserController::class, 'user']);

    //password
    Route::put('/password', [UserController::class, 'edit_password']);
    Route::post('/cek_password', [UserController::class, 'cek_password']);
    Route::post('/edit_password', [UserController::class, 'edit_password']);

    //bank
    Route::post('/add_bank',[ResearcherBankController::class, 'create']);
    Route::post('/edit_bank',[ResearcherBankController::class, 'update']);
    Route::get('/bank/{user_id}', [ResearcherBankController::class, 'show']);

    //user
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/edit_user',[UserController::class, 'edit_user']);
    Route::post('/update_profile',[UserController::class, 'update_profile']);

    //certificate
    Route::get('/cert/{id}/', [CertificateController::class, 'show']);
    Route::get('/cert', [CertificateController::class, 'index']);
    Route::post('/upload_cert',[CertificateController::class, 'store']);
    Route::delete('/cert/{id}', [CertificateController::class, 'delete']);
    Route::post('/update_cert',[CertificateController::class, 'update']);
    // Route::get('/cert_detail/{id}/', [CertificateController::class, 'show_detail']);
    Route::get('/cert_keahlian/{user_id}/', [CertificateController::class, 'show_1']);
    Route::get('/cert_penghargaan/{user_id}/', [CertificateController::class, 'show_2']);

    //report
    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report', [ReportController::class, 'create']);
    Route::get('/report/{id}', [ReportController::class, 'show']);
    Route::get('/report_user/{id}', [ReportController::class, 'show_list_user']);
    Route::get('/report_program/{id}', [ReportController::class, 'show_list_program']);
    Route::get('/count_report/{id}', [ReportController::class, 'count_report_program']);
    Route::get('/total_report/{id}', [ReportController::class, 'total_report']);
    Route::post('/status_report', [ReportController::class, 'change_status']);
    Route::get('/category_report', [ReportController::class, 'category_report']);
    Route::get('/reward_researcher/{id}', [ReportController::class, 'reward_researcher']);
    
    //invite user
    Route::post('/insert_user',  [ProgramController::class, 'set_user']);
    Route::delete('/delete_invited/{id}', [ProgramController::class, 'delete_invited']);
    Route::post('/researcher',  [ProgramController::class, 'researcher_program']);
    Route::get('/researcher/{id}',  [ProgramController::class, 'get_researcher']);
    Route::get('/no_researcher',  [ProgramController::class, 'no_researcher']);
    Route::get('/get_invite/{id}',  [ProgramController::class, 'get_user_invited']);
   
    Route::get('/get_program/{id}',  [ProgramController::class, 'get_user_program']);
    Route::get('send_email/{email}',[SendEmailController::class,'index']);

    //point
    Route::get('/point', [PointController::class, 'index']);
    Route::get('/point_user/{id}', [PointController::class, 'point_user']);
    Route::get('/get_rank/{id}', [PointController::class, 'get_rank']);
    Route::get('/list_point', [PointController::class, 'list_point']);

    //payment
    Route::post('/payment',[PaymentController::class, 'create']);
    Route::get('/payment/{user_id}', [PaymentController::class, 'show']);
    Route::get('/payment_total/{user_id}', [PaymentController::class, 'total']);
    Route::get('/payment_program_company/{user_id}', [PaymentController::class, 'payment_program_company']);
    Route::get('/payment_program_report/{user_id}', [PaymentController::class, 'payment_program_report']);
    Route::get('/payment_researcher_total/{user_id}', [PaymentController::class, 'payment_researcher_total']);
    Route::get('/payment_researcher_process/{user_id}', [PaymentController::class, 'payment_researcher_process']);
});


