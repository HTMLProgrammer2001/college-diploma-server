<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActions;
use App\Http\Controllers\ProfileController;

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

Route::group([], function(){
    //User actions routes

    Route::post('/login', [UserActions::class, 'login'])->name('login');
    Route::post('/logout', [UserActions::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [UserActions::class, 'getMe']);
    Route::post('/editMe', [UserActions::class, 'editMe'])->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'profile'], function(){
    //Profile info routes

    Route::get('/publications', [ProfileController::class, 'getPublications']);
    Route::get('/educations', [ProfileController::class, 'getEducations']);
    Route::get('/honors', [ProfileController::class, 'getHonors']);
    Route::get('/rebukes', [ProfileController::class, 'getRebukes']);
});
