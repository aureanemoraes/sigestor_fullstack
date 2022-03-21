
@extends('layouts.app')

@section('content')
  @include('unidade_gestora.form', [
    'unidade_gestora' => $unidade_gestora
  ])
@endsection

