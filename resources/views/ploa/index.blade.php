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
      <tbody>
        <tr>
          <th colspan="2">Programa</th>
          <td>Nome</td>
        </tr>
        <tr>
          <th colspan="2">Total estimado</th>
          <td>R$ 00,00</td>
        </tr>
        <tr>
          <td colspan="3">
            <table class="table table-light mb-0 table-sm">
              <thead>
                <tr>
                  <th>Ação</th>
                  <th>Fonte</th>
                  <th>Valor</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>R$ 00,00</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        
      </tbody>
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
  $('#ploas').DataTable( {} );
  </script>
@endsection