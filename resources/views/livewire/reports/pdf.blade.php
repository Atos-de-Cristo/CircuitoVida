<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Circuito Vida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            margin-bottom: 10px;
        }
        
        .title {
            background-color: #333;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .subtitle {
            background-color: #ddd;
            padding: 8px;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
        }
        
        .section-title {
            background-color: #f5f5f5;
            padding: 8px;
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0 5px 0;
            border: 1px solid #ddd;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin: 10px 0;
        }
        
        .stats-row {
            display: table-row;
        }
        
        .stats-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        
        .stats-cell.number {
            text-align: center;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .category-section {
            margin-bottom: 25px;
        }
        
        .course-list {
            margin-left: 15px;
        }
        
        .course-item {
            margin: 5px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        
        .period-info {
            font-size: 11px;
            color: #666;
            margin-left: 10px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <div class="logo">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjUwIiB2aWV3Qm94PSIwIDAgMTAwIDUwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8dGV4dCB4PSI1MCIgeT0iMjUiIGZpbGw9IiNmZjZhMDAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZm9udC13ZWlnaHQ9ImJvbGQiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJjZW50cmFsIj5BVE9TPC90ZXh0Pgo8dGV4dCB4PSI1MCIgeT0iNDAiIGZpbGw9IiNmZjZhMDAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSI4IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5ERSBDUklTVE88L3RleHQ+Cjwvc3ZnPgo=" alt="Logo Atos de Cristo" style="max-height: 50px;">
        </div>
        <div class="title">CIRCUITO VIDA</div>
        <div class="subtitle">RELATÓRIO – {{ date('Y') }}/1</div>
    </div>

    <!-- Panorama Geral -->
    <div class="section-title">PANORAMA GERAL</div>
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">TOTAL DE PESSOAS PARTICIPANDO – {{ $reportData['panorama_geral']['total_pessoas_participando'] }}</div>
        </div>
        <div class="stats-row">
            <div class="stats-cell">TOTAL DE INSCRIÇÕES EM CURSOS – {{ $reportData['panorama_geral']['total_inscricoes_em_cursos'] }}</div>
        </div>
        <div class="stats-row">
            <div class="stats-cell">TOTAL DE APROVADOS – {{ $reportData['panorama_geral']['total_aprovados'] }}</div>
        </div>
        <div class="stats-row">
            <div class="stats-cell">TOTAL DE REPROVADOS E DESISTENTES – {{ $reportData['panorama_geral']['total_reprovados_desistentes'] }}</div>
        </div>
    </div>

    <!-- Panorama por Cursos -->
    <div class="section-title">PANORAMA POR CURSOS</div>
    
    @if ((is_array($reportData['dados_por_categoria']) ? count($reportData['dados_por_categoria']) : $reportData['dados_por_categoria']->count()) > 0)
        @foreach ($reportData['dados_por_categoria'] as $categoria)
            <div class="category-section">
                <div style="font-weight: bold; margin: 15px 0 10px 0; font-size: 13px;">
                    • {{ strtoupper(is_object($categoria) ? $categoria->categoria : $categoria['categoria']) }}
                </div>
                
                @php
                    $categoriaName = is_object($categoria) ? $categoria->categoria : $categoria['categoria'];
                    $cursosCategoria = collect($reportData['detalhe_por_curso'])->where('category_name', $categoriaName);
                @endphp
                
                @foreach ($cursosCategoria as $curso)
                    <div style="margin-left: 20px; margin-bottom: 8px;">
                        <strong>{{ is_object($curso) ? $curso->event_name : $curso['event_name'] }}</strong>
                        <div class="period-info">
                            - Período – {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->start_date : $curso['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->end_date : $curso['end_date'])->format('d/m/Y') }}
                        </div>
                        <div style="margin-left: 10px; font-size: 11px;">
                            - Inscritos – {{ is_object($curso) ? $curso->inscritos : $curso['inscritos'] }}<br>
                            - Concluíram – {{ is_object($curso) ? $curso->concluiram : $curso['concluiram'] }}<br>
                            - Reprovados e desistentes – {{ is_object($curso) ? $curso->rep_desist : $curso['rep_desist'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <p>Nenhum curso encontrado para o período selecionado.</p>
    @endif

    @if ((is_array($reportData['detalhe_por_curso']) ? count($reportData['detalhe_por_curso']) : $reportData['detalhe_por_curso']->count()) > 10)
        <!-- Quebra de página se houver muitos cursos -->
        <div class="page-break"></div>
        
        <!-- Tabela detalhada (se necessário) -->
        <div class="section-title">RESUMO DETALHADO</div>
        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Categoria</th>
                    <th>Período</th>
                    <th>Inscritos</th>
                    <th>Concluíram</th>
                    <th>Rep./Desist.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportData['detalhe_por_curso'] as $curso)
                    <tr>
                        <td>{{ is_object($curso) ? $curso->event_name : $curso['event_name'] }}</td>
                        <td>{{ is_object($curso) ? $curso->category_name : $curso['category_name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse(is_object($curso) ? $curso->start_date : $curso['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(is_object($curso) ? $curso->end_date : $curso['end_date'])->format('d/m/Y') }}</td>
                        <td class="text-center">{{ is_object($curso) ? $curso->inscritos : $curso['inscritos'] }}</td>
                        <td class="text-center">{{ is_object($curso) ? $curso->concluiram : $curso['concluiram'] }}</td>
                        <td class="text-center">{{ is_object($curso) ? $curso->rep_desist : $curso['rep_desist'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>{{ $reportData['periodo'] }}</p>
        <p>Relatório gerado em: {{ $reportData['data_geracao'] }}</p>
        <p>Sistema Circuito Vida - Atos de Cristo</p>
    </div>
</body>
</html> 