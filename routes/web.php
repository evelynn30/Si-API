<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PenemuController;
use App\Http\Controllers\InsidenController;
use App\Http\Controllers\JenisSuratKeluarController;
use App\Http\Controllers\JenisSuratMasukController;
use App\Http\Controllers\PerihalSuratController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SifatSuratController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');

// middleware auth

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('penemu', PenemuController::class);
    Route::resource('opd', OpdController::class);
    Route::resource('insiden', InsidenController::class);
    Route::resource('temuan', TemuanController::class);
    Route::resource('perihal_surat', PerihalSuratController::class);
    Route::resource('sifat_surat', SifatSuratController::class);
    Route::resource('jenis_surat_keluar', JenisSuratKeluarController::class);
    Route::resource('jenis_surat_masuk', JenisSuratMasukController::class);
    Route::resource('surat_keluar', SuratKeluarController::class);
    Route::resource('surat_masuk', SuratMasukController::class);

    Route::get('rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');
    Route::get('rekapitulasi/process', [RekapitulasiController::class, 'process'])->name('rekapitulasi.process');
    Route::post('rekapitulasi/export-rekapitulasi', [RekapitulasiController::class, 'exportRekapitulasi'])->name('rekapitulasi.exportRekapitulasi');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/profile', [UserController::class, 'index'])->name('dashboard.profile');
    Route::post('dashboard/profile/update', [UserController::class, 'update'])->name('dashboard.profile.update');
});
