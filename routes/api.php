<?php

use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\StudentController;
use App\Http\Controllers\API\Admin\StaffController;
use App\Http\Controllers\API\Admin\InstructorController;
use App\Http\Controllers\API\Admin\NewsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Users
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/add-user', [UserController::class, 'store']);
    Route::get('/edit-user/{id}', [UserController::class, 'edit']);
    Route::put('/update-user/{id}', [UserController::class, 'update']);
    Route::put('/delete-user/{id}', [UserController::class, 'delete']);
});
// students
Route::group(['prefix' => 'students'], function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/add-student', [StudentController::class, 'store']);
    Route::get('/edit-student/{id}', [StudentController::class, 'edit']);
    Route::put('/update-student/{id}', [StudentController::class, 'update']);
    Route::put('/delete-student/{id}', [StudentController::class, 'delete']);
});
// staffs
Route::group(['prefix' => 'staffs'], function () {
    Route::get('/', [StaffController::class, 'index']);
    Route::post('/add-staff', [StaffController::class, 'store']);
    Route::get('/edit-staff/{id}', [StaffController::class, 'edit']);
    Route::put('/update-staff/{id}', [StaffController::class, 'update']);
    Route::put('/delete-staff/{id}', [StaffController::class, 'delete']);
});
// instructors
Route::group(['prefix' => 'instructors'], function () {
    Route::get('/', [InstructorController::class, 'index']);
    Route::post('/add-instructor', [InstructorController::class, 'store']);
    Route::get('/edit-instructor/{id}', [InstructorController::class, 'edit']);
    Route::put('/update-instructor/{id}', [InstructorController::class, 'update']);
    Route::put('/delete-instructor/{id}', [InstructorController::class, 'delete']);
});

// newContents
Route::group(['prefix' => 'newContents'], function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::post('/add-newContent', [NewsController::class, 'store']);
    Route::get('/edit-newContent/{id}', [NewsController::class, 'edit']);
    Route::put('/update-newContent/{id}', [NewsController::class, 'update']);
    Route::put('/delete-newContent/{id}', [NewsController::class, 'delete']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
});

Route::post('/google-login', [AuthController::class, 'googleLogin']);
