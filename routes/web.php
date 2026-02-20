<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\MasterElemenPenilaianController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerbaikanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Dokumen Routes (Accessible by all authenticated users)
    Route::prefix('dokumen')->name('dokumen.')->group(function () {
        Route::get('/', [DokumenController::class, 'index'])->name('index');
        Route::get('/internal', [DokumenController::class, 'indexInternal'])->name('internal');
        Route::get('/get-dokumenInternal/{id}', [DokumenController::class, 'getDokumenInternal'])->name('getInternal');
        Route::post('/storeInternal', [DokumenController::class, 'storeInternal'])->name('storeInternal');
        Route::post('/updateInternal/{id}', [DokumenController::class, 'updateInternal'])->name('updateInternal');
        Route::delete('/destroyInternal/{id}', [DokumenController::class, 'destroyInternal'])->name('destroyInternal');
        
        Route::get('/eksternal', [DokumenController::class, 'indexEksternal'])->name('eksternal');
        Route::get('/get-dokumenEksternal/{id}', [DokumenController::class, 'getDokumenEksternal'])->name('getEksternal');
        Route::post('/storeEksternal', [DokumenController::class, 'storeEksternal'])->name('storeEksternal');
        Route::post('/updateEksternal/{id}', [DokumenController::class, 'updateEksternal'])->name('updateEksternal');
        Route::delete('/destroyEksternal/{id}', [DokumenController::class, 'destroyEksternal'])->name('destroyEksternal');
        
        // AJAX endpoints for cascading dropdowns
        Route::get('/get-standar/{id_bab}', [DokumenController::class, 'getStandarByBab'])->name('get-standar');
        Route::get('/get-kriteria/{id_standar}', [DokumenController::class, 'getKriteriaByStandar'])->name('get-kriteria');
        Route::get('/get-jenis-dokumen', [DokumenController::class, 'getJenisDokumen'])->name('get-jenis-dokumen');
        Route::get('/get-klaster', [DokumenController::class, 'getKlaster'])->name('get-klaster');
        Route::get('/get-pelayanan', [DokumenController::class, 'getPelayanan'])->name('get-pelayanan');
        Route::get('/get-tahun-dokumen', [DokumenController::class, 'getTahunDokumen'])->name('get-tahun-dokumen');
    });

    // Master Elemen Penilaian Routes (Superadmin only)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::prefix('master/elemen-penilaian')->name('master.elemen-penilaian.')->group(function () {
            Route::get('/', [MasterElemenPenilaianController::class, 'index'])->name('index');
            Route::post('/store', [MasterElemenPenilaianController::class, 'store'])->name('store');
            Route::get('/show/{id}', [MasterElemenPenilaianController::class, 'show'])->name('show');
            Route::post('/update/{id}', [MasterElemenPenilaianController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MasterElemenPenilaianController::class, 'destroy'])->name('destroy');
        });
    });

    // Penilaian Routes (Surveyor only)
    Route::middleware(['role:surveyor'])->group(function () {
        Route::prefix('penilaian')->name('penilaian.')->group(function () {
            Route::post('/store', [PenilaianController::class, 'store'])->name('store');
            Route::get('/get/{id_elemen}', [PenilaianController::class, 'get'])->name('get');
        });
    });

    // Perbaikan Routes (Petugas only)
    Route::middleware(['role:petugas'])->group(function () {
        Route::prefix('perbaikan')->name('perbaikan.')->group(function () {
            Route::post('/store', [PerbaikanController::class, 'store'])->name('store');
            Route::get('/get/{id_elemen}', [PerbaikanController::class, 'get'])->name('get');
            
            // Kegiatan Perbaikan per Triwulan
            Route::get('/kegiatan/{id_perbaikan}', [PerbaikanController::class, 'getKegiatan'])->name('kegiatan.get');
            Route::post('/kegiatan/store', [PerbaikanController::class, 'storeKegiatan'])->name('kegiatan.store');
            Route::post('/kegiatan/update/{id}', [PerbaikanController::class, 'updateKegiatan'])->name('kegiatan.update');
            Route::delete('/kegiatan/delete/{id}', [PerbaikanController::class, 'deleteKegiatan'])->name('kegiatan.delete');
        });
    });
});