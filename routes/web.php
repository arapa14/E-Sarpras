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
    // Pengaduan
    Route::get('/complaint', [ComplaintController::class, 'complaintList'])->name('complaint.list');
    Route::get('/pengaduan/data', [ComplaintController::class, 'getList'])->name('complaint.getList');
    Route::patch('/pengaduan/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaint.updateStatus');
    Route::get('/complaint/detail/{complaint}', [ComplaintController::class, 'detail'])->name('complaint.list.detail');
    Route::post('/response/{complaint}', [ResponseController::class, 'store'])->name('response.store');

    // FAQ & Pertanyaan
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/data', [FaqController::class, 'getFaq'])->name('faq.getFaq');
    // Route untuk menyimpan FAQ baru
    Route::post('/faq', [FaqController::class, 'storeNew'])->name('faq.storeNew');
    // Route untuk update FAQ (inline edit via modal)
    Route::patch('/faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
    // Route untuk update status FAQ (dropdown di DataTables)
    Route::patch('/faq/{faq}/status', [FaqController::class, 'updateStatus'])->name('faq.updateStatus');
    // Route untuk delete FAQ (via Ajax)
    Route::delete('/faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');

    // Pertanyaan (FAQ answer)
    Route::get('/question/data', [QuestionController::class, 'getQuestion'])->name('question.getQuestion');
    Route::get('/question/{question}/answer', [FaqController::class, 'answer'])->name('faq.answer');
    Route::post('/question/{question}/answer', [FaqController::class, 'store'])->name('faq.store');
});
