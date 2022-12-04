<?php

use App\Http\Controllers\Api\StudentMarksController;
use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('students/get_init_data', [StudentsController::class, 'getInitData']);
Route::apiResource('students', StudentsController::class);
Route::get('users/get_init_data', [UsersController::class, 'getInitData']);
Route::apiResource('users', UsersController::class);
Route::get('student_marks/get_init_data', [StudentMarksController::class, 'getInitData']);
Route::apiResource('student_marks', StudentMarksController::class);
