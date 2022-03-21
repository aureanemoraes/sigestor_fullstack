
@extends('layouts.app')

@section('content')
  @include('unidade_administrativa.form', [
    'unidade_administrativa' => $unidade_administrativa
  ])
@endsection

