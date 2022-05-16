@extends('layouts.public')

@section('header-items')
  <div class="header_toggle"></div>
  <div class="header_text">
    <a type="button" href="/login" class="btn btn-primary">Login</a>
  </div>
@endsection

@section('content')
  <div class="img">
    <img src="{{ asset('storage/img/logo-sigestor.png') }}" alt="" height="300px" class="logo">
  </div>
  <div class="card links-container">
    <div class="card-body d-grid gap-2">
      <a href="#" class="btn btn-lg btn-secondary" type="button">Matriz Orçamentária</a>
      <a href="#" class="btn btn-lg btn-secondary" type="button">Metas Estratégicas</a>
    </div>
  </div>
@endsection