<?php

use App\Http\Livewire\Event;
use App\Http\Livewire\EventInscription;
use App\Http\Livewire\EventManager;
use App\Http\Livewire\Inscription;
use App\Http\Livewire\User;
use App\Http\Livewire\Classroom;
use Illuminate\Support\Facades\Route;

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/event/classroom/{id}', Classroom::class)->name('classroom');
    Route::get('/event/manager/{id}', EventManager::class)->name('eventManager');

    Route::middleware('can:admin,monitor')->group(function () {
        Route::get('/event', Event::class)->name('event');
        Route::get('/users', User::class)->name('users');
        Route::get('/event/inscription', EventInscription::class)->name('eventInscription');
    });

    Route::middleware('can:user')->group(function () {
        Route::get('/inscription', Inscription::class)->name('inscription');
    });
});
