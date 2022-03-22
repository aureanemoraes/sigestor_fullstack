
@extends('layouts.app')

@section('content')
  @include('plano_estrategico.form', [
    'plano_estrategico' => $plano_estrategico
  ])
@endsection

