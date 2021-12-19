<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LogoutTokenController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;


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




//Auth
Route::post('register', [RegisterController::class, 'register'])->middleware(['throttle:6,1']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LogoutTokenController::class, 'logout']);
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['throttle:6,1']);
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
//auth:sanctum guard

Route::middleware(['verified','auth:sanctum'])->group(function () {
    Route::post('auth-user', [UserController::class, 'authUser']);
    Route::post('logout', [LogoutTokenController::class, 'logout']);


});
