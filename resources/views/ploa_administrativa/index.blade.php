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
    <h3>MATRIZ PLOA - ADMINISTRATIVA</h3>

    @include('ploa_administrativa.filtro-unidade-administrativa')

    <section class="distribuicao-resumo">
      <div class="table-responsive table-responsive-sm">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>VALOR PLOA</th>
              <th>PLANEJADA</th>
              <th>A PLANEJAR</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ formatCurrency($total_ploa) }}</td>
              <td>{{ formatCurrency($valor_planejado) }}</td>
              <td>{{ formatCurrency($valor_a_planejar) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    @include('ploa_administrativa.tabela-dados')
  @endsection

  @section('js')
    <script>

      let unidade_administrativa_id = null;
      let exercicio_id = null;
      
      $('#unidade_administrativa_id').select2();
      $('#exercicio_id').select2();

      $('#unidade_administrativa_id').on('change', () => {
        unidade_administrativa_id = $('#unidade_administrativa_id').val();
        exercicio_id = $('#exercicio_id').val();

        if(unidade_administrativa_id && exercicio_id)
          window.location.href = `/ploa_administrativa/${unidade_administrativa_id}/${exercicio_id}`;
      });

      $('#exercicio_id').on('change', () => {
        unidade_administrativa_id = $('#unidade_administrativa_id').val();
        exercicio_id = $('#exercicio_id').val();
        if(unidade_administrativa_id && exercicio_id)
          window.location.href = `/ploa_administrativa/${unidade_administrativa_id}/${exercicio_id}`;
      });

      $(document).ready(function() {
          $('#exercicio_id').select2();
          $('#unidade_administrativa_id').select2();
      });
    </script>
  @endsection
@else
  @section('content')
  <h3>MATRIZ PLOA - ADMINISTRATIVA</h3>
  @include('ploa_administrativa.filtro-unidade-administrativa')
  @endsection

  @section('js')
    <script>
      let unidade_administrativa_id = null;
      let exercicio_id = null;
      
      $('#unidade_administrativa_id').select2();
      $('#exercicio_id').select2();

      $('#unidade_administrativa_id').on('change', () => {
        unidade_administrativa_id = $('#unidade_administrativa_id').val();
        if(unidade_administrativa_id && exercicio_id)
          window.location.href = `/ploa_administrativa/${unidade_administrativa_id}/${exercicio_id}`;
      });

      $('#exercicio_id').on('change', () => {
        exercicio_id = $('#exercicio_id').val();
        if(unidade_administrativa_id && exercicio_id)
          window.location.href = `/ploa_administrativa/${unidade_administrativa_id}/${exercicio_id}`;
      });
    </script>
  @endsection
@endif