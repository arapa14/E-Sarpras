<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\serverController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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
Route::get('/switch-back', [UserController::class, 'switchBack'])->name('user.switch.back');

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

Route::middleware(['auth', 'isSuperAdmin'])->group(function () {
    // CRUD User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/getUser', [UserController::class, 'getUser'])->name('user.getUser');
    Route::post('/user', [UserController::class, 'store']);
    Route::patch('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);
    Route::post('/switch/{id}', [UserController::class, 'switchAccount'])->name('user.switch');

    // CRUD Location
    Route::get('/location', [LocationController::class, 'index'])->name('location.index');
    Route::get('/location/getLocation', [LocationController::class, 'getLocation'])->name('location.getLocation');
    Route::post('/location', [LocationController::class, 'store']);
    Route::patch('/location/{location}', [LocationController::class, 'update']);
    Route::delete('/location/{location}', [LocationController::class, 'destroy']);

    // CRUD Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::patch('/setting/update', [SettingController::class, 'update'])->name('setting.update');
});

// Tampilkan halaman form lupa password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
// Proses pengiriman link reset password ke email
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Tampilkan halaman reset password (diakses melalui link email)
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// Proses update password
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Error 403: Forbidden
Route::get('/error-403', function () {
    abort(403, 'Akses ditolak.');
});

// Error 404: Not Found
Route::get('/error-404', function () {
    abort(404, 'Halaman tidak ditemukan.');
});

// Error 405: Not Found
Route::get('/error-405', function () {
    abort(405, 'Metode tidak diizinkan.');
});

// Error 419: Page Expired
Route::get('/error-419', function () {
    abort(419, 'Sesi telah kedaluwarsa.');
});

// Error 500: Internal Server Error
Route::get('/error-500', function () {
    abort(500, 'Terjadi kesalahan pada server.');
});

// Error 502: Bad Gateway
Route::get('/error-502', function () {
    abort(502, 'Bad Gateway.');
});
