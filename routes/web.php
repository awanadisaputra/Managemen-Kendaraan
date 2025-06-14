<?php

use App\Http\Controllers\Log\LaporanController;
use App\Http\Controllers\Log\RiwayatAktivitasController;
use App\Http\Controllers\Log\RiwayatBbmController;
use App\Http\Controllers\Log\RiwayatServisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PersetujuanController;

// Menampilkan landing page
Route::get('/', [AuthController::class, 'landing'])->name('landing');

// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Untuk yang memiliki role admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'indexAdmin'])->name('dashboard');

        // Untuk kendaraan
        Route::prefix('kendaraan')->name('kendaraan.')->group(function () {
            Route::get('/', [KendaraanController::class, 'index'])->name('index');
            Route::get('/create', [KendaraanController::class, 'create'])->name('create');
            Route::post('/', [KendaraanController::class, 'store'])->name('store');
            Route::get('/{kendaraan}', [KendaraanController::class, 'show'])->name('show');
            Route::get('/{kendaraan}/edit', [KendaraanController::class, 'edit'])->name('edit');
            Route::put('/{kendaraan}', [KendaraanController::class, 'update'])->name('update');
            Route::delete('/{kendaraan}', [KendaraanController::class, 'destroy'])->name('destroy');
        });

        // Untuk pemesanan
        Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
            Route::get('/', [PemesananController::class, 'index'])->name('index');
            Route::get('/create', [PemesananController::class, 'create'])->name('create');
            Route::post('/', [PemesananController::class, 'store'])->name('store');
            Route::get('/{pemesanan}', [PemesananController::class, 'show'])->name('show');
            Route::get('/{pemesanan}/edit', [PemesananController::class, 'edit'])->name('edit');
            Route::put('/{pemesanan}', [PemesananController::class, 'update'])->name('update');
            Route::post('/{pemesanan}/selesai', [PemesananController::class, 'selesai'])->name('selesai');
        });

        // Untuk managemen User
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Untuk riwayat servis
        Route::prefix('servis')->name('servis.')->group(function () {
            Route::get('/', [RiwayatServisController::class, 'indexAdmin'])->name('index');
            Route::get('/create', [RiwayatServisController::class, 'create'])->name('create');
            Route::post('/', [RiwayatServisController::class, 'store'])->name('store');
        });
        // Untuk riwayat bbm
        Route::prefix('bbm')->name('bbm.')->group(function () {
            Route::get('/', [RiwayatBbmController::class, 'indexAdmin'])->name('index');
            Route::get('/create', [RiwayatBbmController::class, 'create'])->name('create');
            Route::post('/', [RiwayatBbmController::class, 'store'])->name('store');
        });

        // Untuk riwayat aktivitas
        Route::get('riwayat-aktivitas', [RiwayatAktivitasController::class, 'index'])->name('aktivitas');
    });

    Route::middleware(['role:supervisor,manager'])->prefix('sm')->name('sm.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'indexSM'])->name('dashboard');

        // Untuk persetujuan
        Route::prefix('persetujuan')->name('persetujuan.')->group(function () {
            Route::get('/', [PersetujuanController::class, 'index'])->name('index');
            Route::post('/{persetujuan}/disetujui', [PersetujuanController::class, 'disetujui'])->name('disetujui');
            Route::post('/{persetujuan}/ditolak', [PersetujuanController::class, 'ditolak'])->name('ditolak');
        });

        // Riwayat servis
        Route::get('/sevis', [RiwayatServisController::class, 'indexSM'])->name('servis.index');

        // Riwayat bbm
        Route::get('/bbm', [RiwayatBbmController::class, 'indexSM'])->name('bbm.index');
    });
    // Reports coming
    Route::get('laporan', [LaporanController::class, 'exportLaporan'])->name('laporan');




});