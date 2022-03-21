
@extends('layouts.app')

@section('content')
  @include('programa.form', [
    'programa' => $programa
  ])
@endsection

