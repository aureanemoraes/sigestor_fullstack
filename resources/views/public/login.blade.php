@extends('layouts.public')

@section('header-items')
@endsection

@section('content')
    <div class="img">
        <img src="{{ asset('storage/img/logo-sigestor.png') }}" alt="" height="200px" class="logo">
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('authenticate') }}" method="POST">
                @csrf
                    @error('error')
                        <div class="">
                            {{ $message }}
                        </div>
                    @enderror

                <div class="form-floating mb-3">
                   
                    <input type="text" class="form-control" id="matricula" name="matricula" value="" placeholder="Nº matrícula...">
                    <label for="nome">Nº matrícula</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Nº matrícula...">
                    <label for="nome">Senha</label>
                </div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-link btn-sm" href="/">Esqueci minha senha</a>
                    <button class="btn btn-primary btn-sm" type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection