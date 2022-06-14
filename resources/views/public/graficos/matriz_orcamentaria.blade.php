@extends('layouts.public')

@section('css')
      <style>
        .grafico-acoes {
            border: 1px solid gray;
        }

        .card {
            margin-top: 1rem;
            padding: 1rem;
        }

        .navbar {
            margin-top: 2rem;
        }

        .card {
            max-height: 600px;
        }
      </style>
@endsection

@section('header-items')
@endsection

@section('content')
@include('relatorio.filtros', ['relatorio' => 'simplificado'])
<div class="card">
    <div class="card-body">
        @php
            switch($tipo_relatorio) {
                case 'institucional':
                    $lugar = "INSTITUIÇÃO: $entidade->nome_completo";
                    break;
                case 'gestor':
                    $lugar = "UNIDADE GESTORA: $entidade->nome_completo";
                    break;
                case 'administrativo':
                    $lugar = "UNIDADE ADMINISTRATIVA: $entidade->nome_completo";
                    break;
            }
        @endphp
        <div class="d-flex align-items-end flex-column">
            <p>{{ $lugar }}</p>
        </div>
        <div class="row" >
            <div class="col-md-8 grafico-acoes">
                <p>ORÇAMENTO LOA {{ $exercicio->nome }}</p>
                <div class="mb-3" style="background: white;">
                    @if(is_null($acoes))
                        <p>Não há dados lançados para este exercício.</p>
                    @else
                        {!! $acoes->render() !!}
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="row grafico-acoes">
                    <p>CUSTOS E DESPESAS GERAIS</p>
                    <div class="mb-3" style="background: white;">
                        @if(is_null($despesas))
                            <p>Não há dados lançados para este exercício.</p>
                        @else
                            {!! $despesas->render() !!}
                        @endif
                    </div>
                </div>
                <div class="row grafico-acoes">
                    <p>PLANEJADO E LIBERADO</p>
                    <div class="mb-3" style="background: white;">
                        @if(is_null($recursos))
                            <p>Não há dados lançados para este exercício.</p>
                        @else
                            {!! $recursos->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection