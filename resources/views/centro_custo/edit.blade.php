
@extends('layouts.app')

@section('content')
  @include('centro_custo.form', [
    'centro_custo' => $centro_custo
  ])
@endsection

