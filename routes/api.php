<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\CourseGroupController;
use App\Http\Resources\UserInfoResource;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\MatriculaController;

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

Route::middleware(['auth:sanctum', 'active', 'verified'])->get('/user', function (Request $request) {
	return new UserInfoResource($request->user());
});
Route::get('/register', [UsersController::class, 'getRegister']);
Route::middleware(['auth:sanctum', 'admin', 'active', 'verified'])->group(function () {
	//Registro
	Route::put('/register', [UsersController::class, 'activeRegister']);
	//USUARIOS
	Route::prefix('users')->group(function () {
		Route::get('/', [UsersController::class, 'getUsers']);
		Route::get('/teachers', [UsersController::class, 'getTeachers']);
		Route::post('/', [UsersController::class, 'postUser']);
		Route::put('/{user_id}', [UsersController::class, 'putUser']);
		Route::put('/{user_id}/active', [UsersController::class, 'putUserActive']);
		Route::delete('/{user_id}', [UsersController::class, 'deleteUser']);
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
		Route::prefix('{group_id}')->group(function () {
			Route::get('/', [GroupController::class, 'getGroup']);
			Route::put('/', [GroupController::class, 'putGroup']);
			Route::delete('/', [GroupController::class, 'deleteGroup']);
			//crear un nuevo course group
			Route::post('/', [GroupController::class, 'postGroup']);
		});
	});
	//matriculas
	Route::prefix('matriculas/{course_group_id}')->group(function(){
		Route::get('/',[MatriculaController::class,'getMatriculaStudent']);
		Route::post('/',[MatriculaController::class,'postMatriculaStudent']);
		Route::delete('/{user_id}',[MatriculaController::class,'deleteMatriculaStudent']);
	});
	//cursos y docentes
	Route::get('courses_teachers/{group_id}', [CourseGroupController::class, 'getCoursesTeachers']);
	//CURSOS-GRUPOS
	Route::prefix('course_group/{course_group_id}')->group(function () {
		Route::get('/', [CourseGroupController::class, 'getCourseGroup']);
		Route::put('/', [CourseGroupController::class, 'putCourseGroup']);
		Route::delete('/', [CourseGroupController::class, 'deleteCourseGroup']);
		Route::get('students', [CourseGroupController::class, 'getSearchStudent']);
		Route::post('students', [CourseGroupController::class, 'postStudent']);
	});
	//Libros
	Route::prefix('library')->group(function () {
		Route::get('/', [BookController::class, 'index']);
		Route::post('/', [BookController::class, 'postBook']);
		Route::put('/{book_id}', [BookController::class, 'putBook']);
		Route::delete('/{book_id}', [BookController::class, 'deleteBook']);
	});
});

//docente
Route::middleware(['auth:sanctum', 'teacher', 'active', 'verified'])->group(function () {
	Route::prefix('teacher')->group(function () {
		Route::get('groups', [TeacherController::class, 'getGroups']);
		Route::get('groups/{group_id}', [TeacherController::class, 'getCoursesGroup']);
		Route::get('course_group/{course_group_id}', [TeacherController::class, 'getCourseGroup']);
		Route::post('course_group/{course_group_id}/note', [TeacherController::class, 'postAddNote']);
		Route::post('course_group/{course_group_id}/presence', [TeacherController::class, 'postAddPresence']);
		Route::put('note/{note_id}/{user_id}', [TeacherController::class, 'putUserNote']);
		Route::put('presence/{presence_id}/{user_id}', [TeacherController::class, 'putUserPresence']);
		Route::delete('note/{note_id}', [TeacherController::class, 'deleteUserNote']);
		Route::delete('presence/{presence_id}', [TeacherController::class, 'deleteUserPresence']);
	});
});
//Estudiante
Route::middleware(['auth:sanctum', 'student', 'active', 'verified'])->group(function () {
	Route::prefix('student')->group(function () {
		Route::get('groups', [StudentController::class, 'getGroups']);
		Route::get('groups/{group_id}', [StudentController::class, 'getCoursesGroup']);
		Route::get('course_group/{course_group_id}', [StudentController::class, 'getCourseGroup']);
	});
});
Route::middleware(['auth:sanctum', 'active', 'verified'])->group(function () {
	Route::prefix('academic')->group(function () {
		Route::get('library', [BookController::class, 'index']);
	});
});
