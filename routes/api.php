<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

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
Route::middleware('auth:sanctum')->group(function (){
	Route::get('users', [UsersController::class,'getUsers']);
	Route::get('user_search', [UsersController::class,'getSearch']);
	Route::post('users', [UsersController::class,'postCreateUser']);
	Route::post('import_users', [UsersController::class,'postImportUsers']);
	//Route::get('users', [UsersController::class,'all']);
});