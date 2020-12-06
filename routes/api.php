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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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

Route::get('/report', ReportController::class)->middleware(['auth:api', 'can:viewer']);

Route::group([], function () {
    //User actions routes

    Route::post('/login', [UserActions::class, 'login']);
    Route::get('/login', function (){return abort(403);})->name('login');
    Route::post('/logout', [UserActions::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [UserActions::class, 'getMe']);
    Route::post('/editMe', [UserActions::class, 'editMe'])->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'profile'], function () {
    //Profile info routes

    Route::get('/publications/{id}', [ProfileController::class, 'getPublications']);
    Route::get('/educations/{id}', [ProfileController::class, 'getEducations']);
    Route::get('/honors/{id}', [ProfileController::class, 'getHonors']);
    Route::get('/rebukes/{id}', [ProfileController::class, 'getRebukes']);
    Route::get('/qualifications/{id}', [ProfileController::class, 'getQualifications']);
    Route::get('/internships/{id}', [ProfileController::class, 'getInternships']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'search'], function () {
    //Search routes for dropdowns with live search

    Route::get('/categories', [SearchController::class, 'searchCategories']);
    Route::get('/users', [SearchController::class, 'searchUsers']);
    Route::get('/commissions', [SearchController::class, 'searchCommissions']);
    Route::get('/departments', [SearchController::class, 'searchDepartments']);
    Route::get('/ranks', [SearchController::class, 'searchRanks']);
});

Route::group(['prefix' => 'examples', 'middleware' => ['auth:api', 'can:moderator']], function () {
    //Model import files examples

    Route::get('/publications', [ExportExampleController::class, 'getPublicationExample']);
    Route::get('/honors', [ExportExampleController::class, 'getHonorExample']);
    Route::get('/rebukes', [ExportExampleController::class, 'getRebukeExample']);
    Route::get('/internships', [ExportExampleController::class, 'getInternshipExample']);
    Route::get('/qualifications', [ExportExampleController::class, 'getQualificationExample']);
    Route::get('/users', [ExportExampleController::class, 'getUserExample']);
});

//models CRUD routes

Route::group(['prefix' => 'departments', 'middleware' => 'auth:api'], function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/{department}', [DepartmentController::class, 'show']);
    Route::post('/add', [DepartmentController::class, 'store']);
    Route::put('/{department}', [DepartmentController::class, 'update']);
    Route::delete('/{department}', [DepartmentController::class, 'destroy']);
});

Route::group(['prefix' => 'commissions', 'middleware' => 'auth:api'], function () {
    Route::get('/', [CommissionController::class, 'index']);
    Route::get('/{commission}', [CommissionController::class, 'show']);
    Route::post('/add', [CommissionController::class, 'store']);
    Route::put('/{commission}', [CommissionController::class, 'update']);
    Route::delete('/{commission}', [CommissionController::class, 'destroy']);
});

Route::group(['prefix' => 'ranks', 'middleware' => 'auth:api'], function () {
    Route::get('/', [RankController::class, 'index']);
    Route::get('/{rank}', [RankController::class, 'show']);
    Route::post('/add', [RankController::class, 'store']);
    Route::put('/{rank}', [RankController::class, 'update']);
    Route::delete('/{rank}', [RankController::class, 'destroy']);
});

Route::group(['prefix' => 'categories', 'middleware' => 'auth:api'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{internCategory}', [CategoryController::class, 'show']);
    Route::post('/add', [CategoryController::class, 'store']);
    Route::put('/{internCategory}', [CategoryController::class, 'update']);
    Route::delete('/{internCategory}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'publications', 'middleware' => 'auth:api'], function () {
    Route::get('/', [PublicationController::class, 'index']);
    Route::get('/{publication}', [PublicationController::class, 'show']);
    Route::post('/add', [PublicationController::class, 'store']);
    Route::put('/{publication}', [PublicationController::class, 'update']);
    Route::delete('/{publication}', [PublicationController::class, 'destroy']);
    Route::post('/import', [PublicationController::class, 'import'])
        ->middleware('can:moderator');
});

Route::group(['prefix' => 'honors', 'middleware' => 'auth:api'], function () {
    Route::get('/', [HonorController::class, 'index']);
    Route::get('/{honor}', [HonorController::class, 'show']);
    Route::post('/add', [HonorController::class, 'store']);
    Route::put('/{honor}', [HonorController::class, 'update']);
    Route::delete('/{honor}', [HonorController::class, 'destroy']);
    Route::post('/import', [HonorController::class, 'import'])
        ->middleware('can:moderator');
});

Route::group(['prefix' => 'rebukes', 'middleware' => 'auth:api'], function () {
    Route::get('/', [RebukeController::class, 'index']);
    Route::get('/{rebuke}', [RebukeController::class, 'show']);
    Route::post('/add', [RebukeController::class, 'store']);
    Route::put('/{rebuke}', [RebukeController::class, 'update']);
    Route::delete('/{rebuke}', [RebukeController::class, 'destroy']);
    Route::post('/import', [RebukeController::class, 'import'])
        ->middleware('can:moderator');
});

Route::group(['prefix' => 'educations', 'middleware' => 'auth:api'], function () {
    Route::get('/', [EducationController::class, 'index']);
    Route::get('/{education}', [EducationController::class, 'show']);
    Route::post('/add', [EducationController::class, 'store']);
    Route::put('/{education}', [EducationController::class, 'update']);
    Route::delete('/{education}', [EducationController::class, 'destroy']);
});

Route::group(['prefix' => 'internships', 'middleware' => 'auth:api'], function () {
    Route::get('/', [InternshipController::class, 'index']);
    Route::get('/{internship}', [InternshipController::class, 'show']);
    Route::post('/add', [InternshipController::class, 'store']);
    Route::put('/{internship}', [InternshipController::class, 'update']);
    Route::delete('/{internship}', [InternshipController::class, 'destroy']);
    Route::post('/import', [InternshipController::class, 'import'])
        ->middleware('can:moderator');
});

Route::group(['prefix' => 'qualifications', 'middleware' => 'auth:api'], function () {
    Route::get('/', [QualificationController::class, 'index']);
    Route::get('/{qualification}', [QualificationController::class, 'show']);
    Route::post('/add', [QualificationController::class, 'store']);
    Route::put('/{qualification}', [QualificationController::class, 'update']);
    Route::delete('/{qualification}', [QualificationController::class, 'destroy']);
    Route::post('/import', [QualificationController::class, 'import'])
        ->middleware('can:moderator');
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::post('/add', [UserController::class, 'store']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
    Route::post('/import', [UserController::class, 'import'])
        ->middleware('can:moderator');
});
