
@extends('layouts.app')

@section('content')
  @include('exercicio.form', [
    'exercicio' => $exercicio
  ])
@endsection

