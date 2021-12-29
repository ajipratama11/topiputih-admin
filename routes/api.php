<?php

use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\UserController;
use App\Models\Program;
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



Route::post('/register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('/program', [ProgramController::class, 'index']);
Route::get('/program/{id}', [ProgramController::class, 'show']);
Route::get('/program/search/{name}', [ProgramController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/program', [ProgramController::class, 'create']);
    Route::put('/program/{id}', [ProgramController::class, 'update']);
    Route::delete('/program/{id}', [ProgramController::class, 'delete']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/user',  [UserController::class, 'user']);

});


// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::get('/user', function(Request $request) {
//         // return auth()->user();
//         return
//             $request->user();
//     });

//     Route::resource('programs', App\Http\Controllers\API\ProgramController::class);

//     // API route for logout user
//     Route::post('/logout', [UserController::class, 'logout']);

// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::post('/products', [ProductController::class, 'store']);
//     Route::put('/products/{id}', [ProductController::class, 'update']);
//     Route::delete('/products/{id}', [ProductController::class, 'destroy']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

// Route::get('program/all', 'App\Http\Controllers\API\ProgramController@all');


// Route::post('register', [UserController::class, 'register']);
// Route::post('login', [UserController::class, 'login']);

// Route::post('registercompany', 'App\Http\Controllers\API\CompanyController@register');
// Route::post('logincompany', 'App\Http\Controllers\API\CompanyController@login');
// Route::post('loginc', 'App\Http\Controllers\API\CompanyController@loginc');
