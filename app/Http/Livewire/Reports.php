<?php

namespace App\Http\Livewire;

use App\Services\ReportsService;
use App\Enums\EventStatus;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Reports extends Component
{
    public $start_date = '';
    public $end_date = '';
    public $status = '';
    public $reportData = null;
    public $isGenerating = false;

    protected $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'nullable|string',
    ];

    protected $messages = [
        'start_date.required' => 'Data de início é obrigatória.',
        'start_date.date' => 'Data de início deve ser uma data válida.',
        'end_date.required' => 'Data de fim é obrigatória.',
        'end_date.date' => 'Data de fim deve ser uma data válida.',
        'end_date.after_or_equal' => 'Data de fim deve ser posterior ou igual à data de início.',
    ];

    public function mount()
    {
        // Define um período que contenha dados de teste (2023)
        $this->start_date = '';
        $this->end_date = '';
        $this->status = ''; // Todos os status por padrão
        
        // Não gera preview automaticamente - deixa o usuário clicar
        $this->reportData = null;
    }

    private $reportsServiceInstance;

    public function getReportsServiceProperty()
    {
        if (!$this->reportsServiceInstance) {
            $this->reportsServiceInstance = new ReportsService;
        }
        return $this->reportsServiceInstance;
    }

    public function render()
    {
        return view('livewire.reports.index');
    }

    public function generatePreview()
    {
        // Evita múltiplas execuções simultâneas
        if ($this->isGenerating) {
            return;
        }
        
        $this->validate();
        
        $this->isGenerating = true;
        
        // Limpa dados anteriores
        $this->reportData = null;

        try {
            $this->reportData = $this->reportsService->gerarRelatorio(
                $this->start_date,
                $this->end_date,
                $this->status
            );

            // Limpa mensagens anteriores se os dados foram gerados com sucesso
            if ($this->reportData) {
                session()->forget('message');
            }

        } catch (\Exception $e) {
            $this->reportData = null;
            session()->flash('message', [
                'text' => 'Erro ao gerar relatório: ' . $e->getMessage(),
                'type' => 'error',
            ]);
        } finally {
            $this->isGenerating = false;
        }
    }

    public function downloadPdf()
    {
        $this->validate();

        try {
            $reportData = $this->reportsService->gerarRelatorio(
                $this->start_date,
                $this->end_date,
                $this->status
            );

            $pdf = Pdf::loadView('livewire.reports.pdf', compact('reportData'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true,
                    'defaultFont' => 'Arial'
                ]);

            $filename = 'relatorio_circuito_vida_' . 
                       Carbon::parse($this->start_date)->format('Y-m-d') . '_' .
                       Carbon::parse($this->end_date)->format('Y-m-d') . '.pdf';

            // Para Livewire, precisamos usar JavaScript para fazer o download
            $this->dispatchBrowserEvent('download-pdf', [
                'url' => route('download.report.pdf'),
                'filename' => $filename,
                'data' => [
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'status' => $this->status
                ]
            ]);
        } catch (\Exception $e) {
            session()->flash('message', [
                'text' => 'Erro ao gerar PDF: ' . $e->getMessage(),
                'type' => 'error',
            ]);
        }
    }

    public function clearReport()
    {
        $this->reportData = null;
    }

    public function resetDates()
    {
        $this->start_date = '2023-01-01';
        $this->end_date = '2024-12-31';
        $this->status = '';
        $this->clearReport();
    }

    public function getEventStatusOptionsProperty()
    {
        return [
            '' => 'Todos os Status',
            EventStatus::P->name => EventStatus::P->value,
            EventStatus::A->name => EventStatus::A->value,
            EventStatus::E->name => EventStatus::E->value,
            EventStatus::F->name => EventStatus::F->value,
        ];
    }
} 