@extends('layouts.app')

@section('css')
  <style>
    .total-matriz {
      padding: 0.5rem;
    }

    .distribuicao-resumo {
      margin-bottom: 1rem;
    }
  </style>
@endsection

@section('content')
  <div class="d-flex justify-content-end mb-2 col">
    <a href="{{ route('objetivo.create') }}" type="button" class="btn btn-primary">
      Distribuir
    </a>
  </div>
  <section class="distribuicao-resumo">
    <div class="table-responsive table-responsive-sm">
      <table class="table table-sm">
        <thead>
          <tr>
            <th>VALOR PLOA</th>
            <th>DISTRIBUÍDO</th>
            <th>A DISTRIBUIR</th>
            <th>PLANEJADA</th>
            <th>A PLANEJADA</th>
          </tr>
        </thead>
      </table>
    </div>
  </section>
  @include('ploa.tabela-dados')
@endsection