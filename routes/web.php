<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Models\Categroy;
use App\Models\Customer;
use App\Models\Product;
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

// Customer page 
Route::get('/customerPage', [CustomerController::class, 'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
// API Customer Route----------------
Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id', [CustomerController::class, 'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer', [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);

// Customer page 
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
// Category API Route
Route::post("/create-category", [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-category", [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/category-by-id", [CategoryController::class, 'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-category", [CategoryController::class, 'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-category", [CategoryController::class, 'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);

// Product page 
Route::get('/productPage', [ProductController::class, 'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
// Product API
Route::post("/create-product", [ProductController::class, 'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-product", [ProductController::class, 'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-product", [ProductController::class, 'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-product", [ProductController::class, 'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/product-by-id", [ProductController::class, 'ProductByID'])->middleware([TokenVerificationMiddleware::class]);

// Invoice API Route
Route::post("/invoice-create", [InvoiceController::class, 'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select", [InvoiceController::class, 'invoice_Select'])->middleware([TokenVerificationMiddleware::class]);
