@extends('layouts.app')

@section('content')
<h3>Objetivos Estratégicos</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('objetivo.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="objetivos">
      <thead>
        <th>NOME</th>
        <th>DIMENSÃO ESTRATÉGICA</th>
        <th>EIXO ESTRATÉGICO</th>
        <th>PLANO ESTRATÉGICO</th>
        {{-- <th>EXERCÍCIO DO PLANO DE AÇÃO</th> --}}
        <th>ÍNDICE DE PROGRESSO</th>
        <th>SITUAÇÃO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($objetivos as $objetivo)
        <tr>
          <td>{{ $objetivo->nome }}</td>
          <td>{{ $objetivo->dimensao->nome }}</td>
          <td>{{ $objetivo->dimensao->eixo_estrategico->nome }}</td>
          <td>{{ $objetivo->dimensao->eixo_estrategico->plano_estrategico->nome }}</td>
         
          <td>
            <div class="progress">
              <div style="width: {{ $objetivo->porcentagem_atual . '%'}}" class="progress-bar progress-bar-striped bg-green" role="progressbar"  aria-valuenow="{{ $objetivo->porcentagem_atual }}" aria-valuemin="0" aria-valuemax="100">{{ $objetivo->porcentagem_atual . '%'}}</div>
            </div>
          </td>
          <td><span class="badge btn-primary">{{ $objetivo->ativo ? 'ativo' : 'inativo' }}</span></td>
          <td>
            @if($modo_exibicao == 'metas')
            <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
              <a type="button" href="{{ route('meta.index', ['objetivo' => $objetivo->id]) }}" class="btn btn-primary" ><i class="bi bi-eye-fill"></i> Metas</a>
            </div>
            @else
              <form action="{{ route('objetivo.destroy', $objetivo->id) }}" method="post" id="form-delete">
                @csrf
                @method('delete')
                <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                  <a type="button" href="{{ route('objetivo.edit', $objetivo->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
                  <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                </div>
              </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th>DIMENSÃO ESTRATÉGICA</th>
          <th>EIXO ESTRATÉGICO</th>
          <th>PLANO ESTRATÉGICO</th>
          <th>EXERCÍCIO DO PLANO DE AÇÃO</th>
          <th></th>
          <th></th>
        </tr>
    </tfoot>
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
  $('#objetivos').DataTable( {
        initComplete: function () {
            this.api().columns().every( function (i) {
                if([1, 2, 3, 4].includes(i)) {
                  var column = this;
                  var select = $('<select class="form-select form-select-sm"><option value=""></option></select>')
                      .appendTo( $(column.footer()).empty() )
                      .on( 'change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );
  
                          column
                              .search( val ? '^'+val+'$' : '', true, false )
                              .draw();
                      } );
  
                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  } );
                }
            } );
        }
    } );
  </script>
@endsection