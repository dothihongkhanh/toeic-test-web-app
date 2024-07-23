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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\Listening\ListeningController as ListeningListeningController;
use App\Http\Controllers\Client\Listening\ListeningPracticeController;
use App\Http\Controllers\Client\Listening\PartFourPracticeController;
use App\Http\Controllers\Client\Listening\PartOnePracticeController;
use App\Http\Controllers\Client\Listening\PartThreePracticeController;
use App\Http\Controllers\Client\Listening\PartTwoPracticeController;
use App\Http\Controllers\Client\NotifyController;
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
        Route::get('/', [DashboardController::class, 'index'])->name('admin');

        Route::prefix('users')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('admin.user');
                Route::delete('delete/{id}', 'destroy')->name('admin.users.destroy');
                Route::patch('restore/{id}', 'restore')->name('admin.users.restore');
            });
        });

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
                Route::delete('delete/{id}', 'destroy');
                Route::patch('restore/{id}', 'restore');
            });
            Route::controller(PartOneController::class)->group(function () {
                Route::get('create-part1', 'create');
                Route::post('create-part1', 'store');
                Route::get('list-part1', 'index')->name('list-part1');
                Route::get('detail-part1/{id}', 'show')->name('detail-part1');;
                Route::get('update-part1/{id}', 'edit');
                Route::post('update-part1/{id}', 'update');
            });
            Route::controller(PartTwoController::class)->group(function () {
                Route::get('create-part2', 'create');
                Route::post('create-part2', 'store');
                Route::get('list-part2', 'index')->name('list-part2');
                Route::get('detail-part2/{id}', 'show')->name('detail-part2');;
                Route::get('update-part2/{id}', 'edit');
                Route::post('update-part2/{id}', 'update');
            });
            Route::controller(PartThreeController::class)->group(function () {
                Route::get('create-part3', 'create');
                Route::post('create-part3', 'store');
                Route::get('list-part3', 'index')->name('list-part3');
                Route::get('detail-part3/{id}', 'show')->name('detail-part3');;
                Route::get('update-part3/{id}', 'edit');
                Route::post('update-part3/{id}', 'update');
            });
            Route::controller(PartFourController::class)->group(function () {
                Route::get('create-part4', 'create');
                Route::post('create-part4', 'store');
                Route::get('list-part4', 'index')->name('list-part4');
                Route::get('detail-part4/{id}', 'show')->name('detail-part4');;
                Route::get('update-part4/{id}', 'edit');
                Route::post('update-part4/{id}', 'update');
            });
        });
        Route::prefix('reading')->group(function () {
            Route::controller(ReadingController::class)->group(function () {
                Route::get('list', 'index')->name('admin.reading.list');
                Route::get('detail/{id}', 'show');
                Route::get('update/{id}', 'edit');
                Route::post('update/{id}', 'update');
                Route::delete('delete/{id}', 'destroy');
                Route::patch('restore/{id}', 'restore');
            });
            Route::controller(PartFiveController::class)->group(function () {
                Route::get('create-part5', 'create');
                Route::post('create-part5', 'store');
                Route::get('list-part5', 'index')->name('list-part5');
                Route::get('detail-part5/{id}', 'show')->name('detail-part5');;
                Route::get('update-part5/{id}', 'edit');
                Route::post('update-part5/{id}', 'update');
            });
            Route::controller(PartSixController::class)->group(function () {
                Route::get('create-part6', 'create');
                Route::post('create-part6', 'store');
                Route::get('list-part6', 'index')->name('list-part6');
                Route::get('detail-part6/{id}', 'show')->name('detail-part6');;
                Route::get('update-part6/{id}', 'edit');
                Route::post('update-part6/{id}', 'update');
            });
            Route::controller(PartSevenController::class)->group(function () {
                Route::get('create-part7', 'create');
                Route::post('create-part7', 'store');
                Route::get('list-part7', 'index')->name('list-part7');
                Route::get('detail-part7/{id}', 'show')->name('detail-part7');;
                Route::get('update-part7/{id}', 'edit');
                Route::post('update-part7/{id}', 'update');
            });
        });
    });
});
// client
Route::controller(ClientController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('part', 'showPart');
});

Route::middleware(['verified'])->group(function () {
    Route::controller(NotifyController::class)->group(function () {
        Route::get('/showTimeNotify', 'showTimeNotify')->name('client.showTimeNotify');
        Route::post('/setNotify', 'setNotify')->name('client.setNotify');
        Route::delete('/deleteNotify/{id}', 'deleteNotify')->name('client.deleteNotify');
    });

    Route::controller(ClientController::class)->group(function () {
        Route::get('/profile', 'showProfile')->name('client.profile');
        Route::get('/analytics/id={id}', 'showAnalytics')->name('client.analytics');
        Route::get('/statistical', 'showStatistical')->name('client.statistical');
        Route::get('result/{id}', 'showResult')->name('result');
    });

    Route::prefix('practice-listening')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/', 'showPartListening')->name('client.listening.list');
            Route::post('submit', 'submit')->name('submit');
            Route::get('history/{id}', 'showHistory');
        });
        Route::controller(PartOnePracticeController::class)->group(function () {
            Route::prefix('part1')->group(function () {
                Route::get('/', 'index')->name('practice-list-part1');
                Route::get('detail/{id}', 'show')->name('part1-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part1.result.detail');
            });
        });
        Route::controller(PartTwoPracticeController::class)->group(function () {
            Route::prefix('part2')->group(function () {
                Route::get('/', 'index')->name('practice-list-part2');
                Route::get('detail/{id}', 'show')->name('part2-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part2.result.detail');
            });
        });
        Route::controller(PartThreePracticeController::class)->group(function () {
            Route::prefix('part3')->group(function () {
                Route::get('/', 'index')->name('practice-list-part3');
                Route::get('detail/{id}', 'show')->name('part3-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part3.result.detail');
            });
        });
        Route::controller(PartFourPracticeController::class)->group(function () {
            Route::prefix('part4')->group(function () {
                Route::get('/', 'index')->name('practice-list-part4');
                Route::get('detail/{id}', 'show')->name('part4-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part4.result.detail');
            });
        });
    });

    Route::prefix('practice-reading')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/', 'showPartReading')->name('client.reading.list');
            Route::post('submit', 'submit')->name('submit');
            Route::get('history/{id}', 'showHistory');
        });
        Route::controller(PartFivePracticeController::class)->group(function () {
            Route::prefix('part5')->group(function () {
                Route::get('/', 'index')->name('practice-list-part5');
                Route::get('detail/{id}', 'show')->name('part5-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part5.result.detail');
            });
        });
        Route::controller(PartSixPracticeController::class)->group(function () {
            Route::prefix('part6')->group(function () {
                Route::get('/', 'index')->name('practice-list-part6');
                Route::get('detail/{id}', 'show')->name('part6-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part6.result.detail');
            });
        });
        Route::controller(PartSevenPracticeController::class)->group(function () {
            Route::prefix('part7')->group(function () {
                Route::get('/', 'index')->name('practice-list-part7');
                Route::get('detail/{id}', 'show')->name('part7-detail');
                Route::get('result-detail/{id}', 'showResultDetail')->name('part7.result.detail');
            });
        });
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::post('/vnpay_payment', 'vnpay_payment');
        Route::get('/vnpay-callback', 'vnpay_callback');
    });
});

