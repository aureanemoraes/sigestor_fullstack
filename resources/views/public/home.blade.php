@extends('layouts.public')

@section('content')
  <div class="img">
    <img src="{{ asset('storage/img/logo-sigestor.png') }}" alt="" height="300px" class="logo">
  </div>
  <div class="card links-container">
    <div class="card-body d-grid gap-2">
      <a href="{{ route('graph.matriz.orcamentaria') }}" class="btn btn-lg btn-secondary" type="button">Matriz Orçamentária</a>
      <a href="{{ route('graph.matriz.estrategica') }}" class="btn btn-lg btn-secondary" type="button">Metas Estratégicas</a>
    </div>
  </div>
@endsection