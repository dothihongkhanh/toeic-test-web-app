<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Listening\ListeningController;
use App\Http\Controllers\Admin\Listening\PartFourController;
use App\Http\Controllers\Admin\Listening\PartOneController;
use App\Http\Controllers\Admin\Listening\PartThreeController;
use App\Http\Controllers\Admin\Listening\PartTwoController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Admin\Reading\PartFiveController;
use App\Http\Controllers\Admin\Reading\PartSevenController;
use App\Http\Controllers\Admin\Reading\PartSixController;
use App\Http\Controllers\Admin\Reading\ReadingController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\Listening\ListeningController as ListeningListeningController;
use App\Http\Controllers\Client\Listening\ListeningPracticeController;
use App\Http\Controllers\Client\Listening\PartFourPracticeController;
use App\Http\Controllers\Client\Listening\PartOnePracticeController;
use App\Http\Controllers\Client\Listening\PartThreePracticeController;
use App\Http\Controllers\Client\Listening\PartTwoPracticeController;
use App\Http\Controllers\Client\Reading\PartFivePracticeController;
use App\Http\Controllers\Client\Reading\PartSevenPracticeController;
use App\Http\Controllers\Client\Reading\PartSixPracticeController;
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
            Route::controller(PartSevenController::class)->group(function () {
                Route::get('create-part7', 'create');
                Route::post('create-part7', 'store');
                Route::get('list-part7', 'index')->name('list-part7');
            });
        });
    });
});

Route::get('/', [ClientController::class, 'index']);

Route::middleware(['verified'])->group(function () {
    Route::prefix('practice-listening')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/', 'showPartListening')->name('client.listening.list');
            Route::post('submit', 'submit')->name('submit');
            Route::get('result/{id}', 'showResult')->name('result');
        });
        Route::controller(PartOnePracticeController::class)->group(function () {
            Route::prefix('part1')->group(function () {
                Route::get('/', 'index')->name('practice-list-part1');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part1.result.detail');
            });
        });
        Route::controller(PartTwoPracticeController::class)->group(function () {
            Route::prefix('part2')->group(function () {
                Route::get('/', 'index')->name('practice-list-part2');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part2.result.detail');
            });
        });
        Route::controller(PartThreePracticeController::class)->group(function () {
            Route::prefix('part3')->group(function () {
                Route::get('/', 'index')->name('practice-list-part3');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part3.result.detail');
            });
        });
        Route::controller(PartFourPracticeController::class)->group(function () {
            Route::prefix('part4')->group(function () {
                Route::get('/', 'index')->name('practice-list-part4');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part4.result.detail');
            });
        });
    });

    Route::prefix('practice-reading')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/', 'showPartReading')->name('client.reading.list');
            Route::post('submit', 'submit')->name('submit');
            Route::get('result/{id}', 'showResult')->name('result');
        });
        Route::controller(PartFivePracticeController::class)->group(function () {
            Route::prefix('part5')->group(function () {
                Route::get('/', 'index')->name('practice-list-part5');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part5.result.detail');
            });
        });
        Route::controller(PartSixPracticeController::class)->group(function () {
            Route::prefix('part6')->group(function () {
                Route::get('/', 'index')->name('practice-list-part6');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part6.result.detail');
            });
        });
        Route::controller(PartSevenPracticeController::class)->group(function () {
            Route::prefix('part7')->group(function () {
                Route::get('/', 'index')->name('practice-list-part7');
                Route::get('detail/{id}', 'show');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part7.result.detail');
            });
        });
    });
});
