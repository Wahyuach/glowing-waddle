<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TernakController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\AbkController;
use App\Http\Controllers\KavlingController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rute Kavling
Route::prefix('admin')->group(function () {
    // Rute CRUD untuk Kavling
    Route::get('kavling', [KavlingController::class, 'index'])->name('kavling.index');
    Route::get('kavling/create', [KavlingController::class, 'create'])->name('kavling.create');
    Route::post('kavling', [KavlingController::class, 'store'])->name('kavling.store');
    Route::get('kavling/{kavling}', [KavlingController::class, 'show'])->name('kavling.show');
    Route::get('kavling/{kavling}/edit', [KavlingController::class, 'edit'])->name('kavling.edit');
    Route::put('kavling/{kavling}', [KavlingController::class, 'update'])->name('kavling.update');
    Route::delete('kavling/{kavling}', [KavlingController::class, 'destroy'])->name('kavling.destroy');

    // Rute untuk impor CSV Kavling
    Route::post('kavling/import', [KavlingController::class, 'import'])->name('kavling.import');

    // Rute Kandang NESTED di bawah Kavling
    // URL akan menjadi /admin/kavling/{no_kavling}/kandang
    Route::prefix('kavling/{kavling}')->group(function () { // {kavling} akan menjadi parameter no_kavling
        Route::get('kandang', [KandangController::class, 'index'])->name('kavling.kandang.index');
        Route::get('kandang/create', [KandangController::class, 'create'])->name('kavling.kandang.create');
        Route::post('kandang', [KandangController::class, 'store'])->name('kavling.kandang.store');
        Route::get('kandang/{kandang}', [KandangController::class, 'show'])->name('kavling.kandang.show'); // {kandang} akan menjadi parameter kandang_id
        Route::get('kandang/{kandang}/edit', [KandangController::class, 'edit'])->name('kavling.kandang.edit');
        Route::put('kandang/{kandang}', [KandangController::class, 'update'])->name('kavling.kandang.update');
        Route::delete('kandang/{kandang}', [KandangController::class, 'destroy'])->name('kavling.kandang.destroy');
    });
});

// Rute Ternak
Route::prefix('admin')->group(function () {
    Route::get('ternak', [TernakController::class, 'index'])->name('ternak.index');
    Route::get('ternak/create', [TernakController::class, 'create'])->name('ternak.create');
    Route::post('ternak', [TernakController::class, 'store'])->name('ternak.store');
    Route::get('ternak/{ternak}', [TernakController::class, 'show'])->name('ternak.show');
    Route::get('ternak/{ternak}/edit', [TernakController::class, 'edit'])->name('ternak.edit');
    Route::put('ternak/{ternak}', [TernakController::class, 'update'])->name('ternak.update');
    Route::delete('ternak/bulk-delete', [TernakController::class, 'bulkDelete'])->name('ternak.bulkDelete');
    // Route::delete('ternak/{ternak}', [TernakController::class, 'destroy'])->name('ternak.destroy');

    // URL: /admin/ternak/{tag_number}/weights
    Route::post('ternak/{ternak}/weights', [TernakController::class, 'storeWeightHistory'])->name('ternak.weights.store');
    // URL: /admin/weights/{id}
    Route::put('weights/{id}', [TernakController::class, 'updateWeightHistory'])->name('weights.update');
    Route::delete('weights/{id}', [TernakController::class, 'destroyWeightHistory'])->name('weights.destroy');
    
    // Rute untuk impor CSV Ternak
    Route::post('ternak/import', [TernakController::class, 'import'])->name('ternak.import');
});

// Pakan Routes
Route::prefix('admin')->group(function () {
    Route::get('pakan', [PakanController::class, 'index'])->name('pakan.index');
    Route::get('pakan/create', [PakanController::class, 'create'])->name('pakan.create');
    Route::post('pakan', [PakanController::class, 'store'])->name('pakan.store');
    Route::get('pakan/{pakan}', [PakanController::class, 'show'])->name('pakan.show');
    Route::get('pakan/{pakan}/edit', [PakanController::class, 'edit'])->name('pakan.edit');
    Route::put('pakan/{pakan}', [PakanController::class, 'update'])->name('pakan.update');
    Route::delete('pakan/{pakan}', [PakanController::class, 'destroy'])->name('pakan.destroy');
});

// Investor Routes
Route::prefix('admin')->group(function () {
    Route::get('investor', [InvestorController::class, 'index'])->name('investor.index');
    Route::get('investor/create', [InvestorController::class, 'create'])->name('investor.create');
    Route::post('investor', [InvestorController::class, 'store'])->name('investor.store');
    Route::get('investor/{investor}', [InvestorController::class, 'show'])->name('investor.show');
    Route::get('investor/{investor}/edit', [InvestorController::class, 'edit'])->name('investor.edit');
    Route::put('investor/{investor}', [InvestorController::class, 'update'])->name('investor.update');
    Route::delete('investor/{investor}', [InvestorController::class, 'destroy'])->name('investor.destroy');

    // Rute untuk impor CSV
    Route::post('investor/import', [InvestorController::class, 'import'])->name('investor.import');
});

// ABK (Karyawan) Routes
Route::prefix('admin')->group(function () {
    Route::get('abk', [AbkController::class, 'index'])->name('abk.index');
    Route::get('abk/create', [AbkController::class, 'create'])->name('abk.create');
    Route::post('abk', [AbkController::class, 'store'])->name('abk.store');
    Route::get('abk/{abk}', [AbkController::class, 'show'])->name('abk.show');
    Route::get('abk/{abk}/edit', [AbkController::class, 'edit'])->name('abk.edit');
    Route::put('abk/{abk}', [AbkController::class, 'update'])->name('abk.update');
    Route::delete('abk/{abk}', [AbkController::class, 'destroy'])->name('abk.destroy');

    // Rute untuk impor CSV
    Route::post('abk/import', [AbkController::class, 'import'])->name('abk.import');
});
