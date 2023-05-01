<?php
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::singleton('/dashboard', DashboardController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('demo')->name('demo.')->group(function () {
        Route::view('/form', 'pages.demo.form')->name('form');
        Route::view('/tables', 'pages.demo.tables')->name('tables');
        Route::view('/calendar', 'pages.demo.calendar')->name('calendar');
        Route::view('/buttons', 'pages.demo.buttons')->name('buttons');
        Route::view('/cards', 'pages.demo.cards')->name('cards');
    });
});

require __DIR__.'/auth.php';
