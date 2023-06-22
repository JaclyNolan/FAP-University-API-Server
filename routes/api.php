<?php

use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Admin\StudentController;
use App\Http\Controllers\API\Admin\StaffController;
use App\Http\Controllers\API\Admin\InstructorController;
use App\Http\Controllers\API\Admin\NewsController;
use App\Http\Controllers\API\Admin\CourseController;
use App\Http\Controllers\API\Admin\ClassController;
use App\Http\Controllers\API\Admin\ClassCourseController;
use App\Http\Controllers\API\Admin\ClassEnrollmentController;
use App\Http\Controllers\API\Admin\ClassScheduleController;

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

Route::middleware(['auth:sanctum', 'can:isAdmin'])->group(function () {
    // User with admin  role can access these routes
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/add-user', [UserController::class, 'store']);
        Route::get('/edit-user/{id}', [UserController::class, 'edit']);
        Route::put('/update-user/{id}', [UserController::class, 'update']);
        Route::put('/delete-user/{id}', [UserController::class, 'delete']);
    });
});

Route::middleware(['auth:sanctum', 'can:isAdminOrStaff'])->group(function () {
    // User with admin and staff role can access these routes
    // students
    Route::group(['prefix' => 'students'], function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/add-student', [StudentController::class, 'store']);
        Route::get('/edit-student/{id}', [StudentController::class, 'edit']);
        Route::put('/update-student/{id}', [StudentController::class, 'update']);
        Route::put('/delete-student/{id}', [StudentController::class, 'delete']);
    });
    //staffs
    Route::group(['prefix' => 'staffs'], function () {
        Route::get('/', [StaffController::class, 'index']);
        Route::post('/add-staff', [StaffController::class, 'store']);
        Route::get('/edit-staff/{id}', [StaffController::class, 'edit']);
        Route::put('/update-staff/{id}', [StaffController::class, 'update']);
        Route::put('/delete-staff/{id}', [StaffController::class, 'delete']);
    });
    //instructors
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

    // Courses
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/add-course', [CourseController::class, 'store']);
        Route::get('/edit-course/{id}', [CourseController::class, 'edit']);
        Route::put('/update-course/{id}', [CourseController::class, 'update']);
        Route::put('/delete-course/{id}', [CourseController::class, 'delete']);
    });

    // Class
    Route::group(['prefix' => 'class'], function () {
        Route::get('/', [ClassController::class, 'index']);
        Route::post('/add-class', [ClassController::class, 'store']);
        Route::get('/edit-class/{id}', [ClassController::class, 'edit']);
        Route::put('/update-class/{id}', [ClassController::class, 'update']);
        Route::put('/delete-class/{id}', [ClassController::class, 'delete']);
    });

    // ClassCourse
    Route::group(['prefix' => 'classCourses'], function () {
        Route::get('/', [ClassCourseController::class, 'index']);
        Route::post('/add-classCourse', [ClassCourseController::class, 'store']);
        Route::get('/edit-classCourse/{id}', [ClassCourseController::class, 'edit']);
        Route::put('/update-classCourse/{id}', [ClassCourseController::class, 'update']);
        Route::put('/delete-classCourse/{id}', [ClassCourseController::class, 'delete']);
    });

    // class Enrollments
    Route::group(['prefix' => 'classEnrollments'], function () {
        Route::get('/', [ClassEnrollmentController::class, 'index']);
        Route::post('/add-classEnrollment', [ClassEnrollmentController::class, 'store']);
        Route::get('/edit-classEnrollment/{id}', [ClassEnrollmentController::class, 'edit']);
        Route::put('/update-classEnrollment/{id}', [ClassEnrollmentController::class, 'update']);
        Route::put('/delete-classEnrollment/{id}', [ClassEnrollmentController::class, 'delete']);
    });
});

// Class Schedules
Route::group(['prefix' => 'classSchedules'], function () {
    Route::get('/', [ClassScheduleController::class, 'index']);
    Route::post('/add-classSchedule', [ClassScheduleController::class, 'store']);
    Route::get('/edit-classSchedule/{id}', [ClassScheduleController::class, 'edit']);
    Route::put('/update-classSchedule/{id}', [ClassScheduleController::class, 'update']);
    Route::put('/delete-classSchedule/{id}', [ClassScheduleController::class, 'delete']);
});

Route::middleware(['auth:sanctum', 'can:isInstructor'])->group(function () {
    // User with instructor role can access these routes
});

Route::middleware(['auth:sanctum', 'can:isStudent'])->group(function () {
    // User with student role can access these routes
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
});

Route::post('/google-login', [AuthController::class, 'googleLogin']);
