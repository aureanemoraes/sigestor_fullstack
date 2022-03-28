@extends('layouts.app')

@section('css')
  <style>
    .table-loa {
      max-width: 60rem;
    }

    .table {
      table-layout:fixed;
    }
  </style>
@endsection

@section('content')
<h3>
    PLOA - Matriz
</h3>

<section class="row">
  <div class="d-flex justify-content-end mb-2 col">
    <a href="{{ route('ploa.create') }}" type="button" class="btn btn-primary">
      Novo
    </a>
  </div>
</section>
<section>
  <div class="table-responsive-sm table-loa">
    <table class="table table-secondary table-sm">
      @foreach($programas as $programa)
        @if(count($programa->ploas) > 0)
          <tbody>
            <tr>
              <th colspan="3">Programa</th>
              <td>{{ $programa->nome }}</td>
            </tr>
            <tr>
              <th colspan="3">Total estimado</th>
              <td>{{ formatCurrency($programa->ploas()->sum('valor')) }}</td>
            </tr>
            @foreach($programa->ploas as $ploa)
            <tr>
              <td colspan="4">
                <table class="table table-light mb-0 table-sm">
                  <thead>
                    <tr>
                      <th>Ação</th>
                      <th>Tipo</th>
                      <th>Fonte</th>
                      <th>Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ $ploa->acao_tipo->codigo . ' - ' . $ploa->acao_tipo->nome }}</td>
                      <td>{{ ucfirst($ploa->tipo_acao) }}</td>
                      <td>{{ $ploa->fonte_tipo->codigo }}</td>
                      <td>{{ formatCurrency($ploa->valor) }}</td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            @endforeach
          </tbody>
        @endif
      @endforeach
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
  $('#ploas').DataTable( {} );
  </script>
@endsection