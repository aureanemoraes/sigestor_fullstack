@extends('layouts.app')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    <h3>Creditos Planejados</h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Unidade Gestora - UASG</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->uasg }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Unidade Gestora - SIGLA</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->sigla }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Nº de solicitação</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->numero_solicitacao }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Código do processo</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->codigo_processo }}
                    </p>
                </div>
            </div>
            <div class="row">
                <p>
                    <strong>Despesa</strong>
                </p>
                <p>
                    {{ $credito_planejado->despesa->descricao }}
                </p>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Unidade Administrativa - UASG</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->uasg }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Unidade Administrativa - SIGLA</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Programa</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->programa->nome }} 
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Fonte</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Natureza de despesa</strong>
                    </p>
                    <p>
                        {{ $credito_planejado->despesa->natureza_despesa->nome_completo }}
                    </p>
                </div>
                <div class="col">
                    <p>
                        <strong>Valor</strong>
                    </p>
                    <p>
                        {{ formatCurrency($credito_planejado->despesa->valor_total) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <ul class="list-group list-group-flush">
        @php
            if($credito_planejado->unidade_gestora == 'pendente')
                $class_gestora = 'text-secondary';
            else if($credito_planejado->unidade_gestora == 'deferido')
                $class_gestora = 'text-success';
            else if($credito_planejado->unidade_gestora == 'indeferido')
                $class_gestora = 'text-danger';

            if($credito_planejado->instituicao == 'pendente')
                $class_instituicao = 'text-secondary';
            else if($credito_planejado->instituicao == 'deferido')
                $class_instituicao = 'text-success';
            else if($credito_planejado->instituicao == 'indeferido')
                $class_instituicao = 'text-danger';
        @endphp
        <li class="list-group-item">
            <i class="bi bi-check-circle-fill {{ $class_gestora }}"></i> Aprovação Unidade Gestora
        </li>
        <li class="list-group-item">
            <i class="bi bi-check-circle-fill {{ $class_instituicao }}"></i> Aprovação Instituição
        </li>
    </ul>
    <p>
        @php
            if($tipo == 1) {
                $route = 'credito_planejado.autoriza_gestora';
                $name = 'unidade_gestora';
                $status = $credito_planejado->unidade_gestora;
            } else if ($tipo == 2) {
                $route = 'credito_planejado.autoriza_instituicao';
                $name = 'instituicao';
                $status = $credito_planejado->instituicao;
            }
        @endphp
        @if(in_array($status, ['pendente', 'indeferido']))
            <form action="{{ route($route, $credito_planejado->id) }}" method="POST">
                @csrf
                @method('patch')
                <input type="hidden" name="{{ $name }}" value="deferido">
                <div class="form-group mb-3">
                    <textarea class="form-control" name="comentarios" id="comentarios">{{ $credito_planejado->comentarios }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success mb-3">DEFERIR SOLICITAÇÃO</button>
            </form>
        @else
            <form action="{{ route($route, $credito_planejado->id) }}" method="POST">
                @csrf
                @method('patch')
                <input type="hidden" name="{{ $name }}" value="indeferido">
                <div class="form-group mb-3">
                    <textarea class="form-control" name="comentarios" id="comentarios">{{ $credito_planejado->comentarios }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-danger mb-3">INDEFERIR SOLICITAÇÃO</button>
            </form>
        @endif
    </p>
@endsection

@section('js')
@endsection