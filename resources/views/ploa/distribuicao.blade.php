@extends('layouts.app')

@section('css')
  <style>
    .total-matriz {
      padding: 0.5rem;
    }

    .distribuicao-resumo {
      margin-bottom: 1rem;
    }
    
    .card {
      margin-bottom: 1rem;
    }
  </style>
@endsection

@section('content')
  @include('ploa.filtro-exercicios')
  <div class="d-flex justify-content-end mb-2 col">
    <a href="{{ route('ploa_gestora.index') }}" type="button" class="btn btn-primary">
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
            <th>A PLANEJAR</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ formatCurrency($total_ploa) }}</td>
            <td>{{ formatCurrency($valor_distribuido) }}</td>
            <td>{{ formatCurrency($valor_a_distribuir) }}</td>
            <td>R$ 00,00</td>
            <td>R$ 00,00</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
  @include('ploa.tabela-dados')
@endsection

@section('js')
  <script>
    $('#exercicio_id').on('change', () => {
      window.location.href = `/ploa/distribuicao/${$('#exercicio_id').val()}`;
    });

    $(document).ready(function() {
      $('#exercicio_id').select2();
    });
  </script>
@endsection