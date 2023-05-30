<?php

use App\Http\Livewire\Event;
use App\Http\Livewire\EventInscription;
use App\Http\Livewire\EventManager;
use App\Http\Livewire\EventStudent;
use App\Http\Livewire\Inscription;
use App\Http\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/event', Event::class)->name('event');
    Route::get('/users', User::class)->name('users');

    Route::get('/inscription', Inscription::class)->name('inscription');
    Route::get('/event/inscription', EventInscription::class)->name('eventInscription');
    Route::get('/event/manager/{id}', EventManager::class)->name('eventManager');
    Route::get('/event/student/{id}', EventStudent::class)->name('eventStudent');
});
