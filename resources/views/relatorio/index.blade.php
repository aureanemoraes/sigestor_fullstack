@extends('layouts.app')

@section('css')
<style>
    .collapse {
      margin-top: 1rem;
      width: 100%;
    }
</style>
@endsection

@section('content')
    <h3>Relatórios</h3>
    <div class="list-group">
      <a href="{{ route('relatorio.simplificado') }}" class="list-group-item list-group-item-action" target="_blank">
        Relatório Simplificado
      </a>
      <a href="{{ route('relatorio.geral') }}" class="list-group-item list-group-item-action" target="_blank">Relatório Geral</a>
      <a href="{{ route('relatorio.metas') }}" class="list-group-item list-group-item-action">Relatório de Metas</a>
    </div>
@endsection