<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActions;

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

Route::post('/login', [UserActions::class, 'login']);
Route::post('/logout', [UserActions::class, 'logout'])->middleware('auth:api');
Route::get('/me', [UserActions::class, 'getMe']);
