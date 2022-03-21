
@extends('layouts.app')

@section('content')
  @include('natureza_despesa.form', [
    'natureza_despesa' => $natureza_despesa
  ])
@endsection
