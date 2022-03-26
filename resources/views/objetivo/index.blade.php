@extends('layouts.app')

@section('content')
<h3>
  @if($modo_exibicao == 'metas')
    Metas Estratégicas - Objetivos
  @else
    Objetivos Estratégicos
  @endif
</h3>

<section class="row">
  @if($modo_exibicao == 'metas')
  <div class="d-flex flex-column justify-content-start mb-2 col-2">
    <select class="form-select form-select-sm" aria-label="Default select example" id="plano_acao" name="plano_acao">
      <option selected value="">Plano de ação...</option>
      @foreach($planos_acoes as $plano_acao)
      <option value="{{ $plano_acao->id }}" {{ isset($plano_acao_id) && $plano_acao_id == $plano_acao->id ? 'selected' : null }}>{{ $plano_acao->nome }}</option>
      @endforeach
    </select>
  </div>
  @endif
  <div class="d-flex justify-content-end mb-2 col">
    <a href="{{ route('objetivo.create') }}" type="button" class="btn btn-primary">
      Novo
    </a>
  </div>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="objetivos">
      <thead>
        <tr>
          <th></th>
          <th>DIMENSÃO ESTRATÉGICA</th>
          <th>EIXO ESTRATÉGICO</th>
          <th>PLANO ESTRATÉGICO</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>NOME</th>
          <th>DIMENSÃO ESTRATÉGICA</th>
          <th>EIXO ESTRATÉGICO</th>
          <th>PLANO ESTRATÉGICO</th>
          <th>ÍNDICE DE PROGRESSO</th>
          <th>SITUAÇÃO</th>
          <th></th>
        </tr>
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
              <a type="button" href="{{ route('meta.index', ['objetivo' => $objetivo->id]) }}" class="btn btn-primary btn-sm" ><i class="bi bi-eye-fill"></i> Metas</a>
            @else
            <form action="{{ route('objetivo.destroy', $objetivo->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('meta.index', ['objetivo' => $objetivo->id]) }}" class="btn btn-primary btn-sm" ><i class="bi bi-eye-fill"></i> Metas</a>
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
      </tfoot>
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
  $('#plano_acao').on('change', () => {
    window.location.href = `/objetivo?modo_exibicao=metas&plano_acao=${$('#plano_acao').val()}`;
  });

  $('#objetivos').DataTable( {
    initComplete: function () {
        this.api().columns().every( function (i) {
          if([1, 2, 3].includes(i)) {

            var column = this;
            var select = $('<select class="form-select form-select-sm"><option value=""></option></select>')
                .appendTo( $("#objetivos thead tr:eq(0) th").eq(column.index()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' );
            } );
          }
        });
    }
  });
  </script>
@endsection