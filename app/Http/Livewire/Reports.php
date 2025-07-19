<?php

namespace App\Http\Livewire;

use App\Services\ReportsService;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Reports extends Component
{
    public $start_date = '';
    public $end_date = '';
    public $reportData = null;
    public $isGenerating = false;

    protected $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
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
        $this->start_date = '2023-01-01';
        $this->end_date = '2024-12-31';
        
        // Não gera preview automaticamente - deixa o usuário clicar
        $this->reportData = null;
    }

    public function getReportsServiceProperty()
    {
        return new ReportsService;
    }

    public function render()
    {
        return view('livewire.reports.index');
    }

    public function generatePreview()
    {
        $this->validate();
        
        $this->isGenerating = true;

        try {
            $this->reportData = $this->reportsService->gerarRelatorio(
                $this->start_date,
                $this->end_date
            );

            $cursoCount = is_array($this->reportData['detalhe_por_curso']) ? count($this->reportData['detalhe_por_curso']) : $this->reportData['detalhe_por_curso']->count();
            
            if (empty($this->reportData['detalhe_por_curso']) || $cursoCount == 0) {
                session()->flash('message', [
                    'text' => 'Nenhum evento encontrado no período selecionado. Verifique as datas e tente novamente.',
                    'type' => 'warning',
                ]);
            } else {
                session()->flash('message', [
                    'text' => 'Preview do relatório gerado com sucesso! Encontrados ' . $cursoCount . ' eventos.',
                    'type' => 'success',
                ]);
            }

        } catch (\Exception $e) {
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
                $this->end_date
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
                    'end_date' => $this->end_date
                ]
            ]);

            session()->flash('message', [
                'text' => 'PDF gerado com sucesso! O download deve começar automaticamente.',
                'type' => 'success',
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
        $this->clearReport();
    }
} 