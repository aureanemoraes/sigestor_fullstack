@extends('layouts.app')

@section('css')
  <style>
    table, td, tr {
      height: 100%;
      overflow: auto;
      vertical-align:middle;
    }

    p {
      margin: 0;
      padding: 0;
    }


    div.table-responsive>div.dataTables_wrapper>div.row {
      margin-bottom: 2rem;
    }

    .infos {
      margin-bottom: 1rem;
    }

    .tooltip-value {
      padding: 0;
      margin: 0;
      width: fit-content;
    }

  </style>
@endsection

@section('breadcrumb')
  @include('partials.breadcrumb', [
    'data' => 
      [
        ['nome' => 'Objetivos', 'rota' => 'objetivo.index', 'parametros' => ['modo_exibicao' =>'metas']], 
        ['nome' => 'Meta'] 
      ]
    ]
  )
@endsection

@section('content')
@include('meta.form-checkin')
@include('meta.checkins-list')
<h3>Metas Estratégicas - Metas por objetivo</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('meta.create', ['objetivo' => $objetivo->id]) }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section class="infos">
  <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Plano Estratégico">
    {{ $plano_estrategico }}
  </button>
  <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Eixo Estratégico">
    {{ $eixo_estrategico }}
  </button>
  <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Dimensão Estratégica">
    {{ $dimensao }}
  </button>
  <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Objetivo">
    {{ $objetivo->nome }}
  </button>
</section>
<section>
  <div class="table-responsive">
    <table class="table actual-table" id="metas">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th>PlANO DE AÇÃO</th>
          <th></th>
        </tr>
        <tr>
          <th>DESCRIÇÃO</th>
          <th>ÍNDICE DE PROGRESSO</th>
          <th>RESPONSÁVEIS</th>
          <th>PlANO DE AÇÃO</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($metas as $meta)
        <tr class="odd dt-hasChild shown">
          <td>
            <div class="descricao-meta-container">
              <section>
                <p><strong>{{ Str::upper($meta->nome) }}</strong></p>
                <p>{{ $meta->descricao }}</p>
              </section>
              <section>
                <p class="text-secondary">Valor inicial: {{ formatMetaValue($meta->valor_inicial, $meta->tipo_dado) }} - Valor atingido: {{ formatMetaValue($meta->valor_atingido, $meta->tipo_dado) }} - Meta: {{ formatMetaValue($meta->valor_final, $meta->tipo_dado) }}</p>
              </section>
            </div>
          </td>
          <td>
            <div class="progress">
              <div style="width: {{ $meta->porcentagem_atual . '%'}}" class="progress-bar progress-bar-striped bg-green" role="progressbar"  aria-valuenow="{{ $meta->porcentagem_atual }}" aria-valuemin="0" aria-valuemax="100">{{ $meta->porcentagem_atual . '%'}}</div>
            </div>
          </td>
          <td>
            @foreach($meta->responsaveis as $responsavel)
              <span class="badge bg-secondary">{{ $responsavel->nome }}</span><br>
            @endforeach
          </td>
          <td>{{ formatDate($meta->plano_acao->data_fim, true) }}</td>
          <td class="" >
            <form action="{{ route('meta.destroy', $meta->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formCheckin" onClick="formCheckin({{ $meta->id }}, '{{ $meta->nome }}')">
                  <i class="bi bi-check-square-fill"></i>
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listCheckin" onClick="listCheckin('{{ $meta->nome }}', {{ $meta->checkins }}, {{ $meta->id }})">
                  <i class="bi bi-ui-checks"></i>
                </button>
                <a type="button" href="{{ route('meta.edit', ['metum' => $meta->id, 'objetivo' => $objetivo->id]) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
              </div>
            </form>
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
    function formCheckin(meta_id, nome){
;      $('#form-modal').attr('action', `/meta/checkin/${meta_id}`);
    }

    function listCheckin(nome, checkins, meta_id) {
      $('#tbodyCheckinsTable').html('');
      checkins.map(checkin => {
        $('#tbodyCheckinsTable').append(`
        <tr>
          <td>${checkin.valor_formatado}</td>
          <td>${checkin.descricao}</td>
          <td>${checkin.data_formatada}</td>
          <td>
            <form action="/meta/checkin/destroy/${meta_id}/${checkin.id}" method="post" id="form-delete">
              @csrf
              <input type="hidden" name="_method" value="delete">
              <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-trash3-fill"></i></button></td>
            </form>
        </tr>
        `);
      })
    }

    $(document).ready( function () {
      $('#metas').DataTable({
        initComplete: function () {
        this.api().columns().every( function (i) {
          if([3].includes(i)) {

            var column = this;
            var select = $('<select class="form-select form-select-sm"><option value=""></option></select>')
                .appendTo( $("#metas thead tr:eq(0) th").eq(column.index()).empty() )
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
      $("body").tooltip({ selector: '[data-bs-toggle=tooltip]', customClass: 'tooltip-value' });
    });
  </script>
@endsection