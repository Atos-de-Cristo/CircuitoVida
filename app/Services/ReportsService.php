<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportsService extends BaseService
{
    /**
     * Busca eventos no período especificado
     */
    public function getEventsByPeriod($startDate, $endDate, $status = null)
    {
        $query = DB::table('events')
            ->where('start_date', '>=', $startDate)
            ->where('start_date', '<=', $endDate);
            
        if (!empty($status)) {
            $query->where('status', $status);
        }
            
        $events = $query->select('id', 'name', 'start_date', 'end_date', 'type', 'category_id', 'status')
            ->orderBy('start_date')
            ->get();
        
        return $events;
    }

    /**
     * Gera panorama geral dos eventos no período
     */
    public function getPanoramaGeral($startDate, $endDate, $status = null)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate, $status)->pluck('id')->toArray();
        
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
                SUM(CASE WHEN status = "A" THEN 1 ELSE 0 END) AS total_aprovados,
                SUM(CASE WHEN status = "R" THEN 1 ELSE 0 END) AS total_reprovados_desistentes
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
    public function getDetalhePorCurso($startDate, $endDate, $status = null)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate, $status)->pluck('id')->toArray();
        
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
                SUM(CASE WHEN inscriptions.status != "T" AND inscriptions.status != "P" AND inscriptions.status != "L" THEN 1 ELSE 0 END) AS concluiram,
                SUM(CASE WHEN inscriptions.status = "C" OR inscriptions.status = "R" THEN 1 ELSE 0 END) AS rep_desist
            ')
            ->groupBy('inscriptions.event_id', 'events.name', 'events.start_date', 'events.end_date', 'events.type', 'categories.name')
            ->orderBy('inscriptions.event_id')
            ->get();

        return $inscriptions;
    }

    /**
     * Gera dados agrupados por categoria
     */
    public function getDadosPorCategoria($startDate, $endDate, $status = null)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate, $status)->pluck('id')->toArray();
        
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
                SUM(CASE WHEN inscriptions.status != "T" AND inscriptions.status != "P" AND inscriptions.status != "L" THEN 1 ELSE 0 END) AS total_concluiram,
                SUM(CASE WHEN inscriptions.status = "C" OR inscriptions.status = "R" THEN 1 ELSE 0 END) AS total_rep_desist
            ')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();
    }

    /**
     * Lista os nomes dos concluintes por curso (event_id)
     */
    public function getConcluintesPorCurso($startDate, $endDate, $status = null)
    {
        $eventIds = $this->getEventsByPeriod($startDate, $endDate, $status)->pluck('id')->toArray();
        
        if (empty($eventIds)) {
            return [];
        }

        $rows = DB::table('inscriptions')
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('events', 'inscriptions.event_id', '=', 'events.id')
            ->whereIn('inscriptions.event_id', $eventIds)
            ->where('inscriptions.status', '=', 'A')
            ->select([
                'inscriptions.event_id',
                'users.id as user_id',
                'users.name as user_name',
            ])
            ->orderBy('inscriptions.event_id')
            ->orderBy('users.name')
            ->get();

        $grouped = [];
        foreach ($rows as $row) {
            $eventId = $row->event_id;
            if (!isset($grouped[$eventId])) {
                $grouped[$eventId] = [];
            }
            // Evitar duplicidade por usuário
            if (!isset($grouped[$eventId][$row->user_id])) {
                $grouped[$eventId][$row->user_id] = $row->user_name;
            }
        }

        // Converter mapa de user_id => name para lista de nomes
        foreach ($grouped as $eventId => $usersMap) {
            $grouped[$eventId] = array_values($usersMap);
        }

        return $grouped;
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
    public function gerarRelatorio($startDate, $endDate, $status = null)
    {
        $user = Auth::user();
        
        return [
            'periodo' => $this->formatarPeriodo($startDate, $endDate),
            'panorama_geral' => $this->getPanoramaGeral($startDate, $endDate, $status),
            'eventos' => $this->getEventsByPeriod($startDate, $endDate, $status),
            'detalhe_por_curso' => $this->getDetalhePorCurso($startDate, $endDate, $status),
            'dados_por_categoria' => $this->getDadosPorCategoria($startDate, $endDate, $status),
            'concluintes_por_curso' => $this->getConcluintesPorCurso($startDate, $endDate, $status),
            'data_geracao' => Carbon::now()->format('d/m/Y H:i:s'),
            'usuario_gerador' => $user ? $user->name : 'Usuário não identificado'
        ];
    }
} 
