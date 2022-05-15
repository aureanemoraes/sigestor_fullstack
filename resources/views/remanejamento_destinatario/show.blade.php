@extends('layouts.app')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    <h3>Empenhos</h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Nº Da Certidão de Crédito</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->codigo_certidao }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Data da Certidão de Crédito</strong>
                    </p>
                    <p>
                        {{ formatDate($empenho->certidao_credito->created_at) }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Unidade Gestora - UASG</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->uasg }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Unidade Gestora - SIGLA</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->sigla }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Nº de solicitação</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->numero_solicitacao }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Código do processo</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->codigo_processo }}
                    </p>
                </div>
            </div>
            <div class="row">
                <p>
                    <strong>Despesa</strong>
                </p>
                <p>
                    {{ $empenho->certidao_credito->credito_planejado->despesa->descricao }}
                </p>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Unidade Administrativa - UASG</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->unidade_administrativa->uasg }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Unidade Administrativa - SIGLA</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Programa</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->programa->nome }} 
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Fonte</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Natureza de despesa</strong>
                    </p>
                    <p>
                        {{ $empenho->certidao_credito->credito_planejado->despesa->natureza_despesa->nome_completo }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Valor</strong>
                    </p>
                    <p>
                        {{ formatCurrency($empenho->certidao_credito->credito_planejado->despesa->valor_total) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <h6>Notas fiscais</h6>
    <ul class="list-group list-group-flush">
        @if(count($empenho->notas_fiscais) > 0)
            @foreach($empenho->notas_fiscais as $nota_fiscal)
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        Data NF: {{ formatDate($nota_fiscal['data']) }}
                    </div>
                    <div class="col">
                        Número NF: {{ $nota_fiscal['numero'] }}
                    </div>
                    <div class="col">
                        Valor NF: {{ formatCurrency($nota_fiscal['valor'])}}
                    </div>
                </div>
            </li>
            @endforeach
        @endif
        
@endsection

@section('js')
@endsection