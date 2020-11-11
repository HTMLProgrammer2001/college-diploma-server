<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserActions;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ExportExampleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HonorController;
use App\Http\Controllers\RebukeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\QualificationController;

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
    Route::get('/qualifications', [ProfileController::class, 'getQualifications']);
    Route::get('/internships', [ProfileController::class, 'getInternships']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'search'], function (){
   //Search routes for dropdowns with live search

    Route::get('/categories', [SearchController::class, 'searchCategories']);
    Route::get('/users', [SearchController::class, 'searchUsers']);
});

Route::group(['prefix' => 'examples'], function(){
   //Model import files examples

    Route::get('/publications', [ExportExampleController::class, 'getPublicationExample']);
    Route::get('/honors', [ExportExampleController::class, 'getHonorExample']);
    Route::get('/rebukes', [ExportExampleController::class, 'getRebukeExample']);
    Route::get('/internships', [ExportExampleController::class, 'getInternshipExample']);
    Route::get('/qualifications', [ExportExampleController::class, 'getQualificationExample']);
});

//models CRUD routes
Route::group(['prefix' => 'departments', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [DepartmentController::class, 'all']);
    Route::get('/{id}', [DepartmentController::class, 'single']);
    Route::post('/add', [DepartmentController::class, 'store']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'destroy']);
});

Route::group(['prefix' => 'commissions', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [CommissionController::class, 'all']);
    Route::get('/{id}', [CommissionController::class, 'single']);
    Route::post('/add', [CommissionController::class, 'store']);
    Route::put('/{id}', [CommissionController::class, 'update']);
    Route::delete('/{id}', [CommissionController::class, 'destroy']);
});

Route::group(['prefix' => 'ranks', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [RankController::class, 'all']);
    Route::get('/{id}', [RankController::class, 'single']);
    Route::post('/add', [RankController::class, 'store']);
    Route::put('/{id}', [RankController::class, 'update']);
    Route::delete('/{id}', [RankController::class, 'destroy']);
});

Route::group(['prefix' => 'categories', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [CategoryController::class, 'all']);
    Route::get('/{id}', [CategoryController::class, 'single']);
    Route::post('/add', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'publications', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [PublicationController::class, 'all']);
    Route::get('/{id}', [PublicationController::class, 'single']);
    Route::post('/add', [PublicationController::class, 'store']);
    Route::put('/{id}', [PublicationController::class, 'update']);
    Route::delete('/{id}', [PublicationController::class, 'destroy']);
    Route::post('/import', [PublicationController::class, 'import']);
});

Route::group(['prefix' => 'honors', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [HonorController::class, 'all']);
    Route::get('/{id}', [HonorController::class, 'single']);
    Route::post('/add', [HonorController::class, 'store']);
    Route::put('/{id}', [HonorController::class, 'update']);
    Route::delete('/{id}', [HonorController::class, 'destroy']);
    Route::post('/import', [HonorController::class, 'import']);
});

Route::group(['prefix' => 'rebukes', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [RebukeController::class, 'all']);
    Route::get('/{id}', [RebukeController::class, 'single']);
    Route::post('/add', [RebukeController::class, 'store']);
    Route::put('/{id}', [RebukeController::class, 'update']);
    Route::delete('/{id}', [RebukeController::class, 'destroy']);
    Route::post('/import', [RebukeController::class, 'import']);
});

Route::group(['prefix' => 'educations', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [EducationController::class, 'all']);
    Route::get('/{id}', [EducationController::class, 'single']);
    Route::post('/add', [EducationController::class, 'store']);
    Route::put('/{id}', [EducationController::class, 'update']);
    Route::delete('/{id}', [EducationController::class, 'destroy']);
});

Route::group(['prefix' => 'internships', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [InternshipController::class, 'all']);
    Route::get('/{id}', [InternshipController::class, 'single']);
    Route::post('/add', [InternshipController::class, 'store']);
    Route::put('/{id}', [InternshipController::class, 'update']);
    Route::delete('/{id}', [InternshipController::class, 'destroy']);
    Route::post('/import', [InternshipController::class, 'import']);
});

Route::group(['prefix' => 'qualifications', 'middleware' => 'auth:api', 'where' => ['id' => '[0-9]+']], function (){
    Route::get('/', [QualificationController::class, 'all']);
    Route::get('/{id}', [QualificationController::class, 'single']);
    Route::post('/add', [QualificationController::class, 'store']);
    Route::put('/{id}', [QualificationController::class, 'update']);
    Route::delete('/{id}', [QualificationController::class, 'destroy']);
    Route::post('/import', [QualificationController::class, 'import']);
});
