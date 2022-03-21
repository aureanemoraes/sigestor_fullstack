
@extends('layouts.app')

@section('content')
  @include('acao_tipo.form', [
    'acao_tipo' => $acao_tipo
  ])
@endsection
