<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\CourseGroupController;
use App\Http\Resources\UserInfoResource;
use App\Models\CourseGroup;

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
Route::middleware('auth:sanctum')->group(function () {
	//USUARIOS
	Route::prefix('users')->group(function () {
		Route::get('/', [UsersController::class, 'getUsers']);
		Route::get('/teachers', [UsersController::class, 'getTeachers']);
		Route::post('/', [UsersController::class, 'postUser']);
		Route::put('/{user_id}', [UsersController::class, 'putUser']);
		Route::put('/{user_id}/active', [UsersController::class, 'putUserActive']);
		Route::delete('/{user_id}', [UsersController::class, 'deleteUser']);
		Route::post('/import', [UsersController::class, 'postImportUsers']);
	});
	//PLAN
	Route::prefix('areas')->group(function () {
		Route::get('/', [AreaController::class, 'getAreas']);
		Route::post('/', [AreaController::class, 'postArea']);
		Route::put('/{area_id}', [AreaController::class, 'putArea']);
		Route::delete('/{area_id}', [AreaController::class, 'deleteArea']);
	});
	//CURSOS
	Route::prefix('course')->group(function () {
		Route::post('/{area_id}', [CourseController::class, 'postCourse']);
		Route::put('/{course_id}', [CourseController::class, 'putCourse']);
		Route::delete('/{course_id}', [CourseController::class, 'deleteCourse']);
	});
	//GRUPOS
	Route::prefix('groups')->group(function () {
		Route::get('/', [GroupController::class, 'getGroups']);
		Route::post('/', [GroupController::class, 'postGroups']);
		Route::prefix('{group_id}')->group(function (){
			Route::get('/',[GroupController::class,'getGroup']);
			Route::put('/', [GroupController::class, 'putGroup']);
			Route::delete('/', [GroupController::class, 'deleteGroup']);
			//crear un nuevo course group
			Route::post('/',[GroupController::class,'postGroup']);
		});
	});
	//cursos y docentes
	Route::get('courses_teachers/{group_id}',[CourseGroupController::class,'getCoursesTeachers']);
	//CURSOS-GRUPOS
	Route::prefix('course_group/{course_group_id}')->group(function () {
		Route::get('/', [CourseGroupController::class, 'getCourseGroup']);
		Route::put('/', [CourseGroupController::class, 'putCourseGroup']);
		Route::delete('/', [CourseGroupController::class, 'deleteCourseGroup']);
	});
});
