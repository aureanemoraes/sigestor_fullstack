@extends('layouts.app')

@if(isset($unidade_selecionada))
  @section('css')
    <style>
      .table-loa {
        /* max-width: 60rem; */
      }

      .table {
        table-layout:fixed;
      }

      .collapse {
        width: 100%;
      }

      .select2-container{
        width: 100%!important;
      }

      .card {
        margin-bottom: 1rem;
      }

      .alert {
        margin-top: 1rem;
        width: 100%;
      }

      .float-end {
        margin-right: 1rem;
      }

      .total-matriz {
        padding: 0.5rem;
      }
    </style>
  @endsection

  @section('content')
    <h3>MATRIZ PLOA - GESTORA</h3>

    @include('ploa_gestora.filtro-unidade-gestora')

    <div class="d-flex justify-content-end mb-2 col">
      <a href="{{ route('ploa_gestora.distribuicao') }}" type="button" class="btn btn-primary">
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

    @include('ploa_gestora.tabela-dados')
  @endsection

  @section('js')
    <script>

      let unidade_gestora_id = null;
      let exercicio_id = null;
      
      $('#unidade_gestora_id').select2();
      $('#exercicio_id').select2();

      $('#unidade_gestora_id').on('change', () => {
        unidade_gestora_id = $('#unidade_gestora_id').val();
        exercicio_id = $('#exercicio_id').val();

        if(unidade_gestora_id && exercicio_id)
          window.location.href = `/ploa_gestora/${unidade_gestora_id}/${exercicio_id}`;
      });

      $('#exercicio_id').on('change', () => {
        unidade_gestora_id = $('#unidade_gestora_id').val();
        exercicio_id = $('#exercicio_id').val();
        if(unidade_gestora_id && exercicio_id)
          window.location.href = `/ploa_gestora/${unidade_gestora_id}/${exercicio_id}`;
      });

      $(document).ready(function() {
          $('#exercicio_id').select2();
          $('#unidade_gestora_id').select2();
      });
    </script>
  @endsection
@else
  @section('content')
  <h3>MATRIZ PLOA - GESTORA</h3>
  @include('ploa_gestora.filtro-unidade-gestora')
  @endsection

  @section('js')
    <script>
      let unidade_gestora_id = null;
      let exercicio_id = null;
      
      $('#unidade_gestora_id').select2();
      $('#exercicio_id').select2();

      $('#unidade_gestora_id').on('change', () => {
        unidade_gestora_id = $('#unidade_gestora_id').val();
        if(unidade_gestora_id && exercicio_id)
          window.location.href = `/ploa_gestora/${unidade_gestora_id}/${exercicio_id}`;
      });

      $('#exercicio_id').on('change', () => {
        exercicio_id = $('#exercicio_id').val();
        if(unidade_gestora_id && exercicio_id)
          window.location.href = `/ploa_gestora/${unidade_gestora_id}/${exercicio_id}`;
      });
    </script>
  @endsection
@endif