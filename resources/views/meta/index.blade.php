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
<h3>Metas Estratégicas</h3>
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
        <th>DESCRIÇÃO</th>
        <th>ÍNDICE DE PROGRESSO</th>
        <th>RESPONSÁVEIS</th>
        <th>PlANO DE AÇÃO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($metas as $meta)
        <tr>
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
            <span class="badge btn-primary">{{ formatMetaValue($meta->porcentagem_atual, 'porcentagem')}}</span>
            {{-- <div class="progress">
              <div class="progress-bar progress-bar-striped btn-primary" role="progressbar"  style="width: 10%" aria-valuenow="{{ $meta->porcentagem_atual }}" aria-valuemin="0" aria-valuemax="{{ $meta->valor_final }}">{{ formatMetaValue($meta->porcentagem_atual, 'porcentagem') }}</div>
            </div> --}}
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
                <a type="button" href="{{ route('meta.edit', ['metum' => $meta->id, 'objetivo' => $objetivo->id]) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
              </div>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th>RESPONSÁVEIS</th>
          <th>PLANO DE AÇÃO</th>
          <th></th>
        </tr>
    </tfoot>
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
    $(document).ready( function () {
      $('#metas').DataTable({
      });
      $("body").tooltip({ selector: '[data-bs-toggle=tooltip]', customClass: 'tooltip-value' });
    });
  </script>
@endsection