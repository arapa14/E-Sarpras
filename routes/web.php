<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\serverController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard based on role
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// API
Route::get('/server-time', [serverController::class, 'getServerTime']);

// Route User
Route::middleware(['auth', 'isUser'])->group(function () {
    Route::get('/pengaduan', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');
});