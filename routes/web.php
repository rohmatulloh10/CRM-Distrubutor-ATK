<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

\App\Http\Middleware\PreventBackHistory::class;


// Route Login dan Logout (tetap di luar middleware)
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Group route yang diamankan
Route::middleware('auth', PreventBackHistory::class)->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/grafik/{tahun}', [DashboardController::class, 'grafikSemua'])->name('grafik');
    Route::get('/matrix/pie/{tahun}/{bulan}', [DashboardController::class, 'pieMatrix'])->name('matrix.pie');


    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/store', [UserController::class, 'store'])->name('users.store');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'show'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            // Route::get('/404', [UserController::class, '404'])->name('404');
        });
    });



    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('index');
        // Route::get('/store', [StoreController::class, 'create'])->name('store');
        Route::post('/', [StoreController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StoreController::class, 'edit'])->name('edit');
        Route::post('/{id}', [StoreController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [StoreController::class, 'delete'])->name('delete');
    });

    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('index');
        Route::get('/create', [LeadController::class, 'create'])->name('create');
        Route::post('/', [LeadController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LeadController::class, 'tampil'])->name('edit');
        Route::get('/{tokoId}/owner', [LeadController::class, 'pemilik'])->name('owner');
        Route::post('/{id}', [LeadController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [LeadController::class, 'delete'])->name('delete');
    });

    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/create', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ActivityController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ActivityController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [ActivityController::class, 'delete'])->name('delete');
        Route::get('/{id}/lihat', [ActivityController::class, 'lihat'])->name('lihat');
    });

    Route::prefix('logs')->name('log.')->group(function () {
        Route::get('/', [LogActivityController::class, 'index'])->name('index');
    });

    Route::prefix('access')->name('access.')->group(function () {
        Route::get('/', [AccessController::class, 'index'])->name('index');
        Route::post('/', [AccessController::class, 'update'])->name('update');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/toko', [LaporanController::class, 'toko'])->name('toko');
        Route::get('/toko/pdf', [LaporanController::class, 'tokoexportPDF'])->name('toko.pdf');

        Route::get('/prospek', [LaporanController::class, 'prospek'])->name('prospek');
        Route::get('/prospek/pdf', [LaporanController::class, 'prospekexportPDF'])->name('prospek.pdf');

        Route::get('/aktifitas', [LaporanController::class, 'aktifitas'])->name('aktifitas');
        Route::get('/aktifitas/pdf', [LaporanController::class, 'aktifitasexportPDF'])->name('aktifitas.pdf');

        Route::get('/getData', [LaporanController::class, 'getData'])->name('getData');
        Route::post('/export', [LaporanController::class, 'update'])->name('export');
    });
});



// Route::get('/', function () {
//     return view('Dashboard');
// });
