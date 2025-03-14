<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Models\Categroy;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// api routes------------------
Route::post('/user-registation', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.Login');
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('user.otp');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('verify.otp');
//token verification 
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password')->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update-profile', [UserController::class, 'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);



Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');

// route page
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/UserRegistration', [UserController::class, 'RegistationPage']);
Route::get('/userSendOtp', [UserController::class, 'SendOTPPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
Route::get('/resetPassword', [UserController::class, 'resetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
//dashboard page
Route::get('/dashboard', [DashboardController::class, 'deshboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'profilePage'])->middleware([TokenVerificationMiddleware::class]);

// all page----------------