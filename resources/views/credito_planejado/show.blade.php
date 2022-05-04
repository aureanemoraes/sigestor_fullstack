@extends('layouts.app')

@section('content')
    <h3>Creditos Planejados</h3>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <strong>{{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->uasg }} - {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->sigla }}</strong>
        </li>
        <li class="list-group-item">
            {{ $credito_planejado->numero_solicitacao }} - {{ $credito_planejado->codigo_processo }}
        </li>
        <li class="list-group-item">
            {{ $credito_planejado->despesa->descricao }}
        </li>
        <li class="list-group-item">
            <strong>{{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->uasg }} - {{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}</strong>
        </li>
        <li class="list-group-item">
            {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->programa->nome }} -  {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }} - {{ $credito_planejado->despesa->natureza_despesa->nome_completo }} - {{ $credito_planejado->despesa->valor_total }}
        </li>
    </ul>
@endsection

@section('js')
@endsection