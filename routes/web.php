<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Listening\ListeningController;
use App\Http\Controllers\Admin\Listening\PartOneController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Admin\PartFourController;
use App\Http\Controllers\Admin\PartThreeController;
use App\Http\Controllers\Admin\PartTwoController;
use App\Http\Controllers\Admin\Reading\PartFiveController;
use App\Http\Controllers\Admin\Reading\PartSixController;
use App\Http\Controllers\Admin\Reading\ReadingController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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
                Route::get('list', 'index')->name('admin.parts.list');
                Route::get('create', 'create');
                Route::post('create', 'store');
                Route::get('update/{id}', 'edit');
                Route::post('update/{id}', 'update');
                Route::delete('delete/{id}', 'destroy');
            });
        });

        Route::prefix('listening')->group(function () {
            Route::controller(ListeningController::class)->group(function () {
                Route::get('list', 'index')->name('admin.listening.list');
                Route::get('detail/{id}', 'show');
            });
            Route::controller(PartOneController::class)->group(function () {
                Route::get('create-part1', 'create');
                Route::post('create-part1', 'store');
                Route::get('list-part1', 'index')->name('list-part1');
            });
            Route::controller(PartTwoController::class)->group(function () {
                Route::get('create-part2', 'create');
                Route::post('create-part2', 'store');
                Route::get('list-part2', 'index')->name('list-part2');
            });
            Route::controller(PartThreeController::class)->group(function () {
                Route::get('create-part3', 'create');
                Route::post('create-part3', 'store');
                Route::get('list-part3', 'index')->name('list-part3');
            });
            Route::controller(PartFourController::class)->group(function () {
                Route::get('create-part4', 'create');
                Route::post('create-part4', 'store');
                Route::get('list-part4', 'index')->name('list-part4');
            });
        });
        Route::prefix('reading')->group(function () {
            Route::controller(ReadingController::class)->group(function () {
                Route::get('list', 'index')->name('admin.reading.list');
                Route::get('detail/{id}', 'show');
            });
            Route::controller(PartFiveController::class)->group(function () {
                Route::get('create-part5', 'create');
                Route::post('create-part5', 'store');
                Route::get('list-part5', 'index')->name('list-part5');
            });
            Route::controller(PartSixController::class)->group(function () {
                Route::get('create-part6', 'create');
                Route::post('create-part6', 'store');
                Route::get('list-part6', 'index')->name('list-part6');
            });
        });
    });
});
