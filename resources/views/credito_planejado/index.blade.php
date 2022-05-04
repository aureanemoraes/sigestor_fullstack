@extends('layouts.app')

@section('content')
<h3>Créditos Planejados</h3>
<section>
    <div class="table-responsive table-responsive-sm">
        <table class="table table-sm" id="creditos_planejados">
            <thead>
                <tr>
                  <th>NÚMERO DA SOLICITAÇÃO</th>
                  <th>CÓDIGO DO PROCESSO</th>
                  <th>UNIDADE ADMINISTRATIVA</th>
                  <th>STATUS</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($creditos_planejados as $credito_planejado)
                  <tr>
                    <td>{{ $credito_planejado->numero_solicitacao }}</td>
                    <td>{{ $credito_planejado->codigo_processo }}</td>
                    <td>{{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}</td>
                    <td>{{ $credito_planejado->unidade_gestora }}</td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                        <a type="button" href="{{ route('credito_planejado.show', [$credito_planejado->id, 'tipo' => $tipo]) }}" class="btn btn-primary" ><i class="bi bi-eye-fill"></i></a>
                      </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection

@section('js')
  <script>
    $(document).ready( function () {
      $('#creditos_planejados').DataTable();
    });
  </script>
@endsection