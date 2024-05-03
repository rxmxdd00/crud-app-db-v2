<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/department', [DepartmentController::class, "getData"]);
// Route::post('/department/create', [DepartmentController::class, "storeDepartment"]);
// Route::put('/department/update/{id}', [DepartmentController::class, 'updateDepartment']);
// Route::delete('/department/delete/{id}', [DepartmentController::class, 'deleteDepartment']);
