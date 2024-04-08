<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListeningController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


Route::controller(LoginGoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

// admin
Route::middleware(['verified'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('admin');

        Route::prefix('parts')->group(function () {
            Route::controller(PartController::class)->group(function () {
                Route::get('list', 'index')-> name('admin.parts.list');
                Route::get('create', 'create');
                Route::post('create', 'store');
                Route::get('update/{id}','edit');
                Route::post('update/{id}', 'update');
                Route::delete('delete/{id}', 'destroy');
            });
        });

        Route::prefix('listening')->group(function () {
            Route::controller(ListeningController::class)->group(function () {
                Route::get('list', 'index')-> name('admin.listening.list');
                Route::get('create', 'create');
                Route::post('create', 'store');
            });
        });
    });
});
