<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
    return view('layout.sidenav-layout');
});

//Web Rest API
Route::post("/user-register", [UserController::class, 'registration']);
Route::post("/user-login", [UserController::class, 'login'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/send-otp", [UserController::class, 'sendOTPCode']);
Route::post("/verify-otp", [UserController::class, 'verifyOTPCode']);
Route::post("/reset-password", [UserController::class, 'resetPassword'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/login', function () {
    return view('pages.auth.login-page');
});
Route::get('/registration', function () {
    return view('pages.auth.registration-page');
});
