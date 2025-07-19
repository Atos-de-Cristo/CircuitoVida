<?php

use App\Http\Livewire\{
    AuditLog,
    Event,
    EventInscription,
    EventManager,
    Inscription,
    User,
    Classroom,
    EventActivityQuestion,
    EventCategory,
    EventCourseFrequency,
    ListMessages,
    Reports,
    StudentActivities,
    StudentAttachments,
    UserDetail
};
use Illuminate\Support\Facades\Route;

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'), 'verified' ])->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/messages', ListMessages::class)->name('listMessages');

    Route::middleware(['check.inscription'])->group(function () {
        Route::get('/event/{eventId}/manager', EventManager::class)->name('eventManager');
        Route::get('/event/{eventId}/classroom/{id}', Classroom::class)->name('classroom');
        Route::get('/event/{eventId}/question/{id}', EventActivityQuestion::class)->name('eventActivityQuestion');
        Route::get('/event/{eventId}/frequency', EventCourseFrequency::class)->name('courseFrequency');
    });

    Route::middleware('can:admin')->group(function () {
        Route::get('/audit-log', AuditLog::class)->name('audit');
        Route::get('/event', Event::class)->name('event');
        Route::get('/event/category', EventCategory::class)->name('eventCategory');
        Route::get('/event/inscription', EventInscription::class)->name('eventInscription');
        Route::get('/relatorios', Reports::class)->name('relatorios');
        Route::get('/users', User::class)->name('users');
        Route::get('/users/{id}/details', UserDetail::class)->name('userDetails');
        
        // Rota para download do PDF
        Route::get('/download-report-pdf', function () {
            $startDate = request('start_date');
            $endDate = request('end_date');
            
            if (!$startDate || !$endDate) {
                abort(400, 'Datas são obrigatórias');
            }
            
            $reportsService = new \App\Services\ReportsService();
            $reportData = $reportsService->gerarRelatorio($startDate, $endDate);
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.reports.pdf', compact('reportData'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'defaultFont' => 'Arial'
                ]);
            
            $filename = 'relatorio_circuito_vida_' . 
                       \Carbon\Carbon::parse($startDate)->format('Y-m-d') . '_' .
                       \Carbon\Carbon::parse($endDate)->format('Y-m-d') . '.pdf';
            
            return $pdf->download($filename);
        })->name('download.report.pdf');
    });

    Route::middleware('can:aluno')->group(function () {
        Route::get('/inscription', Inscription::class)->name('inscription');
        Route::get('/activities', StudentActivities::class)->name('activities');
        Route::get('/attachments', StudentAttachments::class)->name('attachments');
    });
});
