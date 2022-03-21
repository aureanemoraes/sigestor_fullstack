
@extends('layouts.app')

@section('content')
  @include('instituicao.form', [
    'instituicao' => $instituicao
  ])
@endsection

