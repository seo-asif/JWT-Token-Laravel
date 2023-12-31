<?php

use App\Http\Controllers\UserController;
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
    return view('email.otpmail');
});

Route::post("/register", [UserController::class, 'registration'])->name('registration');
Route::post("/login", [UserController::class, 'login'])->name('login');
Route::post("/send-otp", [UserController::class, 'sendOTPCode'])->name('send.otp');
