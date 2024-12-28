<?php

use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\WebhookController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('profile')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    Route::post('/telegram/link', [TelegramController::class, 'link'])
        ->name('telegram.link');

    Route::prefix('settings')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('/', 'index')->name('settings.index');
            Route::post('/{id}/update', 'update')->name('settings.update');
        });
    });
});

Route::post('/{botToken}/webhook', WebhookController::class)
    ->name('telegram.webhook')
    ->withoutMiddleware(['web', HandleInertiaRequests::class]);

Route::prefix('/confirmation')->group(function () {
    Route::controller(ConfirmationController::class)->group(function () {
        Route::post('/sendCode', 'sendCode')->name('confirmation.sendCode');
        Route::post('/checkCode', 'checkCode')->name('confirmation.checkCode');
    });
});

require __DIR__ . '/auth.php';
