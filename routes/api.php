<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function(Request $request) {
        return auth()->user();
    });

    Route::resource('programs', App\Http\Controllers\API\ProgramController::class);

    // API route for logout user
    Route::post('/logout', [UserController::class, 'logout']);
});

// Route::get('program', 'App\Http\Controllers\API\ProgramController@all');


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('registercompany', 'App\Http\Controllers\API\CompanyController@register');
Route::post('logincompany', 'App\Http\Controllers\API\CompanyController@login');
Route::post('loginc', 'App\Http\Controllers\API\CompanyController@loginc');
