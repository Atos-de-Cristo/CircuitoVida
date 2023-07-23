<?php

use App\Http\Livewire\{
    Event,
    EventInscription,
    EventManager,
    Inscription,
    User,
    Classroom,
    EventActivityQuestion,
    EventCategory,
    ListMessages,
    StudentActivities,
    StudentAttachments,
    UserDetail
};
use Illuminate\Support\Facades\Route;

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/event/classroom/{id}', Classroom::class)->name('classroom');
    Route::get('/event/manager/{id}', EventManager::class)->name('eventManager');
    Route::get('/event/question/{id}', EventActivityQuestion::class)->name('eventActivityQuestion');
    Route::get('/messages', ListMessages::class)->name('listMessages');

    Route::middleware('can:admin,monitor')->group(function () {
        Route::get('/event', Event::class)->name('event');
        Route::get('/event/category', EventCategory::class)->name('eventCategory');
        Route::get('/event/inscription', EventInscription::class)->name('eventInscription');
        Route::get('/users', User::class)->name('users');
        Route::get('/users/details/{id}', UserDetail::class)->name('userDetails');
    });

    Route::middleware('can:aluno')->group(function () {
        Route::get('/inscription', Inscription::class)->name('inscription');
        Route::get('/activities', StudentActivities::class)->name('activities');
        Route::get('/attachments', StudentAttachments::class)->name('attachments');
    });
});
