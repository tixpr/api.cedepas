<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
//para probar emails
use App\Models\User;
use App\Mail\EmailConfirmMail;
use App\Mail\PasswordRecoverMail;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['login' => false, 'logout' => false, 'verify' => true]);
Route::get('/', function () {
	return view('welcome');
});
Route::get('login', function () {
	return redirect()->away('https://webapp.seminarioandinosanpablo.org.pe/#/login');
})->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
