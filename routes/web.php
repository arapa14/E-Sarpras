<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
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

Route::middleware(['auth', 'isAdminOrSuperAdmin'])->group(function () {
    Route::get('/complaint', [ComplaintController::class, 'complaintList'])->name('complaint.list');
    Route::get('/pengaduan/data', [ComplaintController::class, 'getList'])->name('complaint.getList');
    Route::patch('/pengaduan/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaint.updateStatus');

    // Route untuk halaman detail pengaduan
    Route::get('/complaint/detail/{complaint}', [ComplaintController::class, 'detail'])->name('complaint.list.detail');
    // Route untuk menyimpan respon admin
    Route::post('/response/{complaint}', [ResponseController::class, 'store'])->name('response.store');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

    Route::get('/question/data', [QuestionController::class, 'getQuestion'])->name('question.getQuestion');
    Route::get('/faq/data', [FaqController::class, 'getFaq'])->name('faq.getFaq');

     // Halaman untuk menjawab pertanyaan
     Route::get('/question/{question}/answer', [FaqController::class, 'answer'])->name('faq.answer');
     Route::post('/question/{question}/answer', [FaqController::class, 'store'])->name('faq.store');
});