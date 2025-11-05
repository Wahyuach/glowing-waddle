<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TernakController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\AbkController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\KavlingController;


Route::get('/', function () {
    return view('welcome');
});

// Rute Auth (login, register, dll)
Auth::routes();

// ---------------------------------------------------------------------
// SEMUA USER (INVESTOR & ADMIN) YANG SUDAH LOGIN
// ---------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {



    // Dashboard utama (investor & admin bisa lihat)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile (investor & admin bisa lihat)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profil.index');        
    Route::post('/profile', [ProfileController::class, 'update'])->name('profil.update'); // This needs to be defined!
    Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.reset-password');
    Route::post('/profile/subscribe', [ProfileController::class, 'subscribe'])->name('profil.subscribe');
    // Endpoint to mark payment as completed (called from client after snap onSuccess)
    Route::post('/profile/payment-complete', [ProfileController::class, 'paymentComplete'])->name('profil.payment.complete');

    
    //RUTE KHUSUS INVESTOR !!
    // URL: /ternak-saya
    Route::get('/mitra-saya', [TernakController::class, 'myMitra'])->name('admin.mitraku');

    // ubah status
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});


// ---------------------------------------------------------------------
// GRUP 2: KHUSUS UNTUK ADMIN
// ---------------------------------------------------------------------
Route::middleware(['auth', 'mitra'])->prefix('mitra')->group(function () {

    // --- Rute Kavling ---
    // URL: /mitra/kavling
    Route::get('kavling', [KavlingController::class, 'index'])->name('kavling.index');
    Route::get('kavling/create', [KavlingController::class, 'create'])->name('kavling.create');
    Route::post('kavling', [KavlingController::class, 'store'])->name('kavling.store');
    Route::get('kavling/{kavling}', [KavlingController::class, 'show'])->name('kavling.show');
    Route::get('kavling/{kavling}/edit', [KavlingController::class, 'edit'])->name('kavling.edit');
    Route::put('kavling/{kavling}', [KavlingController::class, 'update'])->name('kavling.update');
    Route::delete('kavling/{kavling}', [KavlingController::class, 'destroy'])->name('kavling.destroy');
    Route::post('kavling/import', [KavlingController::class, 'import'])->name('kavling.import');

    // Rute Kandang NESTED 
    // URL: /mitra/kavling/{kavling}/kandang
    Route::prefix('kavling/{kavling}')->group(function () {
        Route::get('kandang', [KandangController::class, 'index'])->name('kavling.kandang.index');
        Route::get('kandang/create', [KandangController::class, 'create'])->name('kavling.kandang.create');
        Route::post('kandang', [KandangController::class, 'store'])->name('kavling.kandang.store');
        Route::get('kandang/{kandang}', [KandangController::class, 'show'])->name('kavling.kandang.show');
        Route::get('kandang/{kandang}/edit', [KandangController::class, 'edit'])->name('kavling.kandang.edit');
        Route::put('kandang/{kandang}', [KandangController::class, 'update'])->name('kavling.kandang.update');
        Route::delete('kandang/{kandang}', [KandangController::class, 'destroy'])->name('kavling.kandang.destroy');
    });

    // --- Rute Ternak (Admin) ---
    // URL: /mitra/ternak
    Route::get('ternak', [TernakController::class, 'index'])->name('ternak.index');
    Route::get('ternak/create', [TernakController::class, 'create'])->name('ternak.create');
    Route::post('ternak', [TernakController::class, 'store'])->name('ternak.store');
    Route::get('ternak/{ternak}', [TernakController::class, 'show'])->name('ternak.show');
    Route::get('ternak/{ternak}/edit', [TernakController::class, 'edit'])->name('ternak.edit');
    Route::put('ternak/{ternak}', [TernakController::class, 'update'])->name('ternak.update');
    Route::delete('ternak/bulk-delete', [TernakController::class, 'bulkDelete'])->name('ternak.bulkDelete');

    // Rute weight history 
    Route::post('ternak/{ternak}/weights', [TernakController::class, 'storeWeightHistory'])->name('ternak.weights.store');
    Route::put('weights/{id}', [TernakController::class, 'updateWeightHistory'])->name('weights.update');
    Route::delete('weights/{id}', [TernakController::class, 'destroyWeightHistory'])->name('weights.destroy');
    Route::post('ternak/import', [TernakController::class, 'import'])->name('ternak.import');

    // --- Rute Pakan (mitra) ---
    // URL: /mitra/pakan
    Route::get('pakan', [PakanController::class, 'index'])->name('pakan.index');
    Route::get('pakan/create', [PakanController::class, 'create'])->name('pakan.create');
    Route::post('pakan', [PakanController::class, 'store'])->name('pakan.store');
    Route::get('pakan/{pakan}', [PakanController::class, 'show'])->name('pakan.show');
    Route::get('pakan/{pakan}/edit', [PakanController::class, 'edit'])->name('pakan.edit');
    Route::put('pakan/{pakan}', [PakanController::class, 'update'])->name('pakan.update');
    Route::delete('pakan/{pakan}', [PakanController::class, 'destroy'])->name('pakan.destroy');

    // --- Rute Investor (mitra) ---
    // URL: /mitra/investor
    Route::get('investor', [InvestorController::class, 'index'])->name('investor.index');
    Route::get('investor/create', [InvestorController::class, 'create'])->name('investor.create');
    Route::post('investor', [InvestorController::class, 'store'])->name('investor.store');
    Route::get('investor/{investor}', [InvestorController::class, 'show'])->name('investor.show');
    Route::get('investor/{investor}/edit', [InvestorController::class, 'edit'])->name('investor.edit');
    Route::put('investor/{investor}', [InvestorController::class, 'update'])->name('investor.update');
    Route::delete('investor/{investor}', [InvestorController::class, 'destroy'])->name('investor.destroy');
    Route::post('investor/import', [InvestorController::class, 'import'])->name('investor.import');

    // --- Rute ABK (mitra) ---
    // URL: /mitra/abk
    Route::get('abk', [AbkController::class, 'index'])->name('abk.index');
    Route::get('abk/create', [AbkController::class, 'create'])->name('abk.create');
    Route::post('abk', [AbkController::class, 'store'])->name('abk.store');
    Route::get('abk/{abk}', [AbkController::class, 'show'])->name('abk.show');
    Route::get('abk/{abk}/edit', [AbkController::class, 'edit'])->name('abk.edit');
    Route::put('abk/{abk}', [AbkController::class, 'update'])->name('abk.update');
    Route::delete('abk/{abk}', [AbkController::class, 'destroy'])->name('abk.destroy');
    Route::post('abk/import', [AbkController::class, 'import'])->name('abk.import');


    // // --- Rute Logbook (Catatan Kejadian) ---
    // Route::prefix('logbooks')->group(function () {
    //     // Halaman Daftar Logbook
    //     Route::get('/', [LogbookController::class, 'index'])->name('logbooks.index');
    //     // Halaman Tambah Logbook
    //     Route::get('/create', [LogbookController::class, 'create'])->name('logbooks.create');
    //     // Proses Simpan Logbook
    //     Route::post('/', [LogbookController::class, 'store'])->name('logbooks.store');
    //     // Halaman Detail Logbook
    //     Route::get('/{logbook}', [LogbookController::class, 'show'])->name('logbooks.show');
    //     // Halaman Edit Logbook
    //     Route::get('/{logbook}/edit', [LogbookController::class, 'edit'])->name('logbooks.edit');
    //     // Proses Update Logbook
    //     Route::put('/{logbook}', [LogbookController::class, 'update'])->name('logbooks.update');
    //     // Proses Hapus Logbook
    //     Route::delete('/{logbook}', [LogbookController::class, 'destroy'])->name('logbooks.destroy');
    // });
});
