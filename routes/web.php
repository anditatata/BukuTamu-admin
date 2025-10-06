<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TamuUmumController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

// Halaman form user
Route::get('/user/form', [UserController::class, 'create'])->name('user.form');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

// (hapus yg lama, diganti di bawah ini)
Route::get('/tamu/export', [TamuController::class, 'export'])->name('tamu.export');


// Guest routes (no authentication required)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/latest-meta', [DashboardController::class, 'latestMeta'])->name('dashboard.latest_meta');
    Route::get('/dashboard/stream', [DashboardController::class, 'stream'])->name('dashboard.stream');

    // Tamu Umum routes
    Route::get('/tamu-umum', [TamuUmumController::class, 'index'])->name('tamu_umum.index');
    Route::get('/tamu-umum/create', [TamuUmumController::class, 'create'])->name('tamu_umum.create');
    Route::post('/tamu-umum/store', [TamuUmumController::class, 'store'])->name('tamu_umum.store');
    Route::put('/tamu-umum/{tamu_umum}', [TamuUmumController::class, 'update'])->name('tamu_umum.update');
    Route::get('/tamu-umum/{tamu_umum}/edit', [TamuUmumController::class, 'edit'])->name('tamu_umum.edit');
    Route::delete('/tamu-umum/{tamu_umum}', [TamuUmumController::class, 'destroy'])->name('tamu_umum.destroy');
    Route::get('/tamu-umum/export/excel', [TamuUmumController::class, 'export'])->name('tamu_umum.export.excel');
  Route::post('/tamu-umum/store', [TamuUmumController::class, 'store'])->name('tamu_umum.store');


    // Orang Tua routes
    Route::get('/ortu', [OrangTuaController::class, 'index'])->name('ortu.index');
    Route::get('/ortu/create', [OrangTuaController::class, 'create'])->name('ortu.create');
    Route::post('/ortu/store', [OrangTuaController::class, 'store'])->name('ortu.store');
    Route::get('/ortu/{ortu}/edit', [OrangTuaController::class, 'edit'])->name('ortu.edit');
    Route::put('/ortu/{ortu}', [OrangTuaController::class, 'update'])->name('ortu.update');
    Route::delete('/ortu/{ortu}', [OrangTuaController::class, 'destroy'])->name('ortu.destroy');
    Route::get('/ortu/export/excel', [OrangTuaController::class, 'export'])->name('ortu.export.excel');

    // Instansi routes
    Route::get('/instansi', [InstansiController::class, 'index'])->name('instansi.index');
    Route::get('/instansi/create', [InstansiController::class, 'create'])->name('instansi.create');
    Route::post('/instansi/store', [InstansiController::class, 'store'])->name('instansi.store');
    Route::get('/instansi/{instansi}/edit', [InstansiController::class, 'edit'])->name('instansi.edit');
    Route::put('/instansi/{instansi}', [InstansiController::class, 'update'])->name('instansi.update');
    Route::delete('/instansi/{instansi}', [InstansiController::class, 'destroy'])->name('instansi.destroy');
    Route::get('/instansi/export/excel', [InstansiController::class, 'export'])->name('instansi.export.excel');

    // Kunjungan routes
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});
