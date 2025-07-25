<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsService extends BaseService
{
    /**
     * Busca eventos no período especificado
     */
    public function getEventsByPeriod($startDate, $endDate)
    {
        $events = DB::table('events')
            ->where('start_date', '>=', $startDate)
            ->where('start_date', '<=', $endDate)
            ->select('id', 'name', 'start_date', 'end_date', 'type', 'category_id', 'status')
            ->orderBy('start_date')
            ->get();
        
        return $events;
    }

    /**
     * Gera panorama geral dos eventos no período
     */
    public function getPanoramaGeral($startDate, $endDate)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate)->pluck('id')->toArray();
        
        if (empty($eventIds)) {
            return [
                'total_pessoas_participando' => 0,
                'total_inscricoes_em_cursos' => 0,
                'total_aprovados' => 0,
                'total_reprovados_desistentes' => 0
            ];
        }

        $result = DB::table('inscriptions')
            ->whereIn('event_id', $eventIds)
            ->selectRaw('
                COUNT(DISTINCT user_id) AS total_pessoas_participando,
                COUNT(*) AS total_inscricoes_em_cursos,
                SUM(CASE WHEN status = "L" THEN 1 ELSE 0 END) AS total_aprovados,
                SUM(CASE WHEN status = "P" THEN 1 ELSE 0 END) AS total_reprovados_desistentes
            ')
            ->first();

        return [
            'total_pessoas_participando' => $result->total_pessoas_participando ?? 0,
            'total_inscricoes_em_cursos' => $result->total_inscricoes_em_cursos ?? 0,
            'total_aprovados' => $result->total_aprovados ?? 0,
            'total_reprovados_desistentes' => $result->total_reprovados_desistentes ?? 0
        ];
    }

    /**
     * Gera relatório detalhado por curso/evento
     */
    public function getDetalhePorCurso($startDate, $endDate)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate)->pluck('id')->toArray();
        
        if (empty($eventIds)) {
            return collect();
        }

        $inscriptions = DB::table('inscriptions')
            ->join('events', 'inscriptions.event_id', '=', 'events.id')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->whereIn('inscriptions.event_id', $eventIds)
            ->selectRaw('
                inscriptions.event_id,
                events.name as event_name,
                events.start_date,
                events.end_date,
                events.type,
                categories.name as category_name,
                COUNT(*) AS inscritos,
                SUM(CASE WHEN inscriptions.status = "L" THEN 1 ELSE 0 END) AS concluiram,
                SUM(CASE WHEN inscriptions.status = "P" THEN 1 ELSE 0 END) AS rep_desist
            ')
            ->groupBy('inscriptions.event_id', 'events.name', 'events.start_date', 'events.end_date', 'events.type', 'categories.name')
            ->orderBy('inscriptions.event_id')
            ->get();

        return $inscriptions;
    }

    /**
     * Gera dados agrupados por categoria
     */
    public function getDadosPorCategoria($startDate, $endDate)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate)->pluck('id')->toArray();
        
        if (empty($eventIds)) {
            return collect();
        }

        return DB::table('inscriptions')
            ->join('events', 'inscriptions.event_id', '=', 'events.id')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->whereIn('inscriptions.event_id', $eventIds)
            ->selectRaw('
                categories.name as categoria,
                COUNT(DISTINCT inscriptions.event_id) as total_cursos,
                COUNT(*) AS total_inscritos,
                SUM(CASE WHEN inscriptions.status = "L" THEN 1 ELSE 0 END) AS total_concluiram,
                SUM(CASE WHEN inscriptions.status = "P" THEN 1 ELSE 0 END) AS total_rep_desist
            ')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();
    }

    /**
     * Formata período para exibição
     */
    public function formatarPeriodo($startDate, $endDate)
    {
        $inicio = Carbon::parse($startDate)->format('d/m/Y');
        $fim = Carbon::parse($endDate)->format('d/m/Y');
        return "Período: {$inicio} - {$fim}";
    }

    /**
     * Gera dados completos para o relatório
     */
    public function gerarRelatorio($startDate, $endDate)
    {
        return [
            'periodo' => $this->formatarPeriodo($startDate, $endDate),
            'panorama_geral' => $this->getPanoramaGeral($startDate, $endDate),
            'eventos' => $this->getEventsByPeriod($startDate, $endDate),
            'detalhe_por_curso' => $this->getDetalhePorCurso($startDate, $endDate),
            'dados_por_categoria' => $this->getDadosPorCategoria($startDate, $endDate),
            'data_geracao' => Carbon::now()->format('d/m/Y H:i:s')
        ];
    }
} 