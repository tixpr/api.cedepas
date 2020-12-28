<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Resources\UserInfoResource;

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
    return new UserInfoResource($request->user());
});
Route::middleware('auth:sanctum')->group(function (){
	//USUARIOS
	Route::prefix('users')->group(function(){
		Route::get('/', [UsersController::class,'getUsers']);
		Route::get('/teachers', [UsersController::class,'getTeachers']);
		Route::post('/', [UsersController::class,'postUser']);
		Route::put('/{user_id}', [UsersController::class,'putUser']);
		Route::put('/{user_id}/active', [UsersController::class,'putUserActive']);
		Route::delete('/{user_id}', [UsersController::class,'deleteUser']);
		Route::post('/import', [UsersController::class,'postImportUsers']);
	});
	//PERIODOS
	Route::prefix('groups')->group(function (){
		Route::get('/', [GroupController::class,'getGroups']);
		Route::post('/', [GroupController::class,'postGroup']);
		Route::put('/{group_id}', [GroupController::class,'putGroup']);
		Route::delete('/{group_id}', [GroupController::class,'deleteGroup']);
	});
	//CURSOS
	Route::prefix('courses/{group_id}')->group(function(){
		Route::get('/', [CourseController::class,'getCourses']);
		Route::post('/', [CourseController::class,'postCourse']);
		Route::post('/import', [CoursesController::class,'postImportCourses']);
	});
	Route::prefix('course')->group(function(){
		Route::get('/{course_id}',[CourseController::class,'getCourse']);
		Route::put('/{course_id}',[CourseController::class,'putCourse']);
		Route::delete('/{course_id}',[CourseController::class,'deleteCourse']);
	});
});