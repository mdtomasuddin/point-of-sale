<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/user-registation', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.Login');
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('user.otp');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('verify.otp');


