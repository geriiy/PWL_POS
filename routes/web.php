<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenjualanController;

Route::pattern('id', '[0-9]+');

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    // User routes
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Level routes (khusus ADM dan OWN)
    Route::middleware(['authorize:ADM,MNG'])->prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/', [LevelController::class, 'store']);
        Route::post('/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
    });

    // Kategori routes
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::post('/list', [KategoriController::class, 'list']);
        Route::get('/create', [KategoriController::class, 'create']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);
        Route::get('/{id}', [KategoriController::class, 'show']);
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
    });

    // Suplier routes
    Route::prefix('suplier')->group(function () {
        Route::get('/', [SuplierController::class, 'index']);
        Route::post('/list', [SuplierController::class, 'list']);
        Route::get('/create', [SuplierController::class, 'create']);
        Route::get('/create_ajax', [SuplierController::class, 'create_ajax']);
        Route::post('/', [SuplierController::class, 'store']);
        Route::post('/ajax', [SuplierController::class, 'store_ajax']);
        Route::get('/{id}', [SuplierController::class, 'show']);
        Route::get('/{id}/edit', [SuplierController::class, 'edit']);
        Route::put('/{id}', [SuplierController::class, 'update']);
        Route::get('/{id}/edit_ajax', [SuplierController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [SuplierController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [SuplierController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [SuplierController::class, 'delete_ajax']);
        Route::delete('/{id}', [SuplierController::class, 'destroy']);
        Route::get('/export', [SuplierController::class, 'export'])->name('suplier.export');
        Route::post('/import', [SuplierController::class, 'import'])->name('suplier.import');
        Route::get('/export/pdf', [SuplierController::class, 'exportPdf'])->name('suplier.export.pdf');
    });

    // Barang routes
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        Route::get('/create', [BarangController::class, 'create']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/', [BarangController::class, 'store']);
        Route::post('/ajax', [BarangController::class, 'store_ajax']);
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
        Route::get('/detail/{id}', [BarangController::class, 'detail'])->name('barang.detail');
        Route::get('/import', [BarangController::class, 'import']);
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
        Route::get('/export_excel', [BarangController::class, 'export_excel']);
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
    });

    // Stok routes
    Route::prefix('stok')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('stok.index');
        Route::get('/list', [StokController::class, 'list'])->name('stok.list');
        Route::get('/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/store', [StokController::class, 'store'])->name('stok.store');
    
        Route::get('/{id}', [StokController::class, 'show'])->name('stok.show'); // Route untuk Lihat Detail
        Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit'); // Route untuk Edit
        Route::put('/{id}', [StokController::class, 'update'])->name('stok.update'); // Route untuk Update
        Route::delete('/destroy/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
    });

    // Transaksi routes
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/get', [TransaksiController::class, 'getTransaksi'])->name('transaksi.get');
        Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::get('/transaksi/list', [TransaksiController::class, 'list'])->name('transaksi.list');
        Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{id}/show_ajax', [TransaksiController::class, 'show_ajax'])->name('transaksi.show');
        Route::get('/{id}/delete_ajax', [TransaksiController::class, 'delete_ajax'])->name('transaksi.delete_ajax');
        Route::delete('/{id}/destroy', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });

    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::post('/penjualan/list', [PenjualanController::class, 'list'])->name('penjualan.list'); // DataTables Ajax
        Route::get('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    });

});
