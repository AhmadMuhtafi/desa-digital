<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\ProfilDesaController;
use App\Http\Controllers\Admin\KontakDesaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profil-desa', [ProfilDesaController::class, 'index'])
            ->name('profil-desa.index');

        Route::put('/profil-desa', [ProfilDesaController::class, 'update'])
            ->name('profil-desa.update');

        Route::get('/kontak-desa', [KontakDesaController::class, 'index'])
            ->name('kontak-desa.index');

        Route::put('/kontak-desa', [KontakDesaController::class, 'update'])
            ->name('kontak-desa.update');

        Route::resource('menu', MenuController::class)
            ->middleware('admin');

        Route::resource('kategori', KategoriController::class)
            ->except(['show']);

        Route::resource('users', UserController::class)
            ->middleware('admin');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])
            ->name('pengaturan.index')
            ->middleware('admin');

        Route::put('/pengaturan', [PengaturanController::class, 'update'])
            ->name('pengaturan.update')
            ->middleware('admin');
    });
    