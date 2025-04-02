<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\serverController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('landing');
Route::get('/auth', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard based on role
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// API
Route::get('/server-time', [serverController::class, 'getServerTime']);

// Route Landing
Route::post('/question', [QuestionController::class, 'store'])->name('question.store');

// Route User
Route::middleware(['auth', 'isUser'])->group(function () {
    Route::get('/pengaduan', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaint.store');
    Route::get('/riwayat', [ComplaintController::class, 'riwayat'])->name('complaint.riwayat');
    Route::get('/riwayat/data', [ComplaintController::class, 'getRiwayat'])->name('complaint.getRiwayat');
    Route::get('/complaint/{complaint}', [ComplaintController::class, 'show'])->name('complaint.detail');
});