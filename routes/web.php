<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect()->route('dashboard.admin');
    }

    return redirect()->route('dashboard.user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');

        // CRUD Mobil
        Route::get('/admin/mobil', [MobilController::class, 'index'])->name('admin.mobil.index');
        Route::get('/admin/mobil/create', [MobilController::class, 'create'])->name('admin.mobil.create');
        Route::post('/admin/mobil', [MobilController::class, 'store'])->name('admin.mobil.store');
        Route::put('/admin/mobil/{id}', [MobilController::class, 'update'])->name('admin.mobil.update');

        // Manajemen Mobil
        Route::get('/manajemen-mobil', [MobilController::class, 'index'])->name('mobil');

        // 🧠 Route Pelanggan (URUTAN PENTING)
        Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('pelanggan.search'); // ⬅️ harus di atas {id}
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
        Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    });



Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::post('/user/beli/{id}', [UserController::class, 'beli'])->name('user.beli');
    });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('dashboard.profile');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('dashboard.profile.destroy');
});

require __DIR__ . '/auth.php';
