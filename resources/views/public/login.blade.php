@extends('layouts.public')

@section('header-items')
@endsection

@section('content')
    <div class="img">
        <img src="{{ asset('storage/img/logo-sigestor.png') }}" alt="" height="200px" class="logo">
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="numero_matricula" name="numero_matricula" value="" placeholder="Nº matrícula...">
                <label for="nome">Nº matrícula</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="senha" name="senha" value="" placeholder="Nº matrícula...">
                <label for="nome">Senha</label>
            </div>
            <div class="d-flex justify-content-between">
                <a class="btn btn-link btn-sm" href="/">Esqueci minha senha</a>
                <a class="btn btn-primary btn-sm" href="/inicio">Entrar</a>
            </div>
        </div>
    </div>
@endsection