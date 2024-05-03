<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\API\RegisterController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/addToken', [ApiController::class, "createToken"]);

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});



Route::middleware('auth:sanctum')->group( function(){
    Route::resource('departments', DepartmentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('students', StudentController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::post('logout', [RegisterController::class, 'logout']);
});



// Route::middleware(['apiauth'])->group(function(){
//     Route::get('/department', [DepartmentController::class, "getData"]);
//     Route::post('/department/create', [DepartmentController::class, "storeDepartment"]);
//     Route::put('/department/update/{id}', [DepartmentController::class, 'updateDepartment']);
//     Route::delete('/department/delete/{id}', [DepartmentController::class, 'deleteDepartment']);

//     Route::get('/course', [CourseController::class, "getCourses"]);
//     Route::post('/course', [CourseController::class, "addCourse"]);
//     Route::put('/course/update/{id}', [CourseController::class, 'updateCourse']);
//     Route::delete('/course/delete/{id}', [CourseController::class, 'deleteCourse']);

//     Route::get('/student', [StudentController::class, "getStudent"]);
//     Route::post('/student', [StudentController::class, "addStudent"]);
//     Route::put('/student/update/{id}', [StudentController::class, 'updateStudent']);
//     Route::delete('/student/delete/{id}', [StudentController::class, 'deleteStudent']);

//     Route::get('/enrollment', [EnrollmentController::class, "getEnrollment"]);
//     Route::post('/enrollment', [EnrollmentController::class, "addEnrollment"]);
//     Route::put('/enrollment/update/{id}', [EnrollmentController::class, 'updateEnrollment']);
//     Route::delete('/enrollment/delete/{id}', [EnrollmentController::class, 'deleteEnrollment']);
// });
