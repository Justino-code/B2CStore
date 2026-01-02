<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .titulo {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .subtitulo {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .info-box {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        
        .info-label {
            font-weight: bold;
            color: #2c3e50;
            display: inline-block;
            width: 150px;
        }
        
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #e8f4fd;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .valor {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="titulo">{{ $titulo }}</div>
        <div class="subtitulo">Período: {{ $periodo['inicio'] }} até {{ $periodo['fim'] }}</div>
    </div>
    
    <div class="info-box">
        <div><span class="info-label">Data de Geração:</span> {{ $dataGeracao }}</div>
        <div><span class="info-label">Tipo de Relatório:</span> {{ ucfirst($abaAtiva) }}</div>
        
        @if(!empty($filtros))
            <div><span class="info-label">Filtros Aplicados:</span></div>
            @foreach($filtros as $nome => $valor)
                <div style="margin-left: 150px;">• {{ $nome }}: {{ $valor }}</div>
            @endforeach
        @endif
    </div>
    
    @switch($abaAtiva)
        @case('vendas')
            @include('exports.partials.relatorio-vendas-pdf')
            @break
            
        @case('produtos')
            @include('exports.partials.relatorio-produtos-pdf')
            @break
            
        @case('clientes')
            @include('exports.partials.relatorio-clientes-pdf')
            @break
            
        @case('categorias')
            @include('exports.partials.relatorio-categorias-pdf')
            @break
            
        @case('cupons')
            @include('exports.partials.relatorio-cupons-pdf')
            @break
    @endswitch
    
    <div class="footer">
        Gerado automaticamente pelo Sistema de Relatórios<br>
    </div>
</body>
</html>