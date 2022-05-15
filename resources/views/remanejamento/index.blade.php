@extends('layouts.app')

@section('css')
  <style>
    .table-loa {
      /* max-width: 60rem; */
    }

    .table {
      table-layout:fixed;
      vertical-align: middle;
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
  <h3>PLOA - {{ $exercicio->nome }} - UNIDADES GESTORAS</h3>
  <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">
  @include('loa_gestora.filtro-unidade-gestora', ['unidades_administrativas' => $unidades_administrativas])
  @include('loa_gestora.navbar')

  @if(isset($unidade_administrativa_selecionada))
  @else
    <div class="text-center">
      <p class="text-secondary">Selecione a unidade administrativa para remanejar valores.</p>
    </div>
  @endif

  @foreach($acoes as $acao)
    <h6>{{ $acao->nome_completo }}</h6>
    @foreach($naturezas_despesas as $natureza_despesa)
        <div class="card">
            <div class="card-body">
              <div class="table-responsive-sm table-loa">
                  <table class="table table-sm">
                      @if(count($natureza_despesa->despesas) > 0)
                          <tbody>
                              <tr>
                                  <td colspan="3">NATUREZA DE DESPESA: <strong>{{ $natureza_despesa->nome_completo }}</strong></td>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                              <tr>
                                  <td colspan="3">Total estimado</td>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                              <tr>
                              <td colspan="7">
                                  <table class="table mb-0 table-sm">
                                      <thead>
                                          <tr>
                                              <th>DESPESA</th>
                                              <th>FONTE</th>
                                              <th>VALOR UNITÁRIO</th>
                                              <th></th>
                                              <th>VALOR TOTAL</th>
                                              <th>TIPO</th>
                                              <th></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($natureza_despesa->despesas as $despesa)
                                              @if($despesa->ploa_administrativa->ploa_gestora->ploa->acao_tipo_id == $acao->id)
                                              <tr>
                                                <td>{{ $despesa->descricao }}</td>
                                                <td>{{ $despesa->fonte }}</td>
                                                <td>{{ formatCurrency($despesa->valor) }}</td>
                                                <td>
                                                  @if(isset($despesa->fields) && count($despesa->fields) > 0)
                                                    @foreach($despesa->fields as $field)
                                                      {{ $field['nome'] . ': ' . $field['valor']}}
                                                    @endforeach
                                                  @endif
                                                </td>
                                                <td>{{ formatCurrency($despesa->valor_total) }}</td>
                                                <td>{{ $despesa->tipo }}</td>
                                                <td>
                                                  <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                                                    @if(isset($despesa->remanejamento_id))
                                                        <a type="button" href="{{ route('remanejamento_destinatario.create', ['ploa' => $exercicio->id, 'unidade_gestora' => $unidade_selecionada->id, 'remanejamento' => $despesa->remanejamento_id]) }}" class="btn btn-primary" >Remanejar valor <i class="bi bi-box-arrow-right"></i></a>
                                                    @else
                                                        <a type="button" href="{{ route('remanejamento.create', ['despesa' => $despesa->id, 'tipo' => 1]) }}" class="btn btn-primary" >Liberar valor <i class="bi bi-box-arrow-right"></i></a>
                                                    @endif
                                                    <a type="button" href="{{ route('remanejamento.historico', [$despesa->id, 1]) }}" class="btn btn-primary" >Histórico <i class="bi bi-list"></i></a>
                                                  </div>
                                                </td>
                                              </tr>
                                              @endif
                                          @endforeach
                                      </tbody>
                                  </table>
                              </td>
                              </tr>
                          </tbody>
                      @endif
                  </table>
              </div>
            </div>
        </div>
    @endforeach
  @endforeach
@endsection

@section('js')
  <script>
    $('#unidade_gestora_id').on('change', () => {
        let exercicio_id = $('#exercicio_id').val();
        let unidade_gestora_id = $('#unidade_gestora_id').val();
        let unidade_administrativa_id = $('#unidade_administrativa_id').val();
        if(unidade_gestora_id)
            window.location.href = `/remanejamento?tipo=1&ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}&unidade_administrativa=${unidade_administrativa_id}`;
    });

    $('#unidade_administrativa_id').on('change', () => {
        let exercicio_id = $('#exercicio_id').val();
        let unidade_gestora_id = $('#unidade_gestora_id').val();
        let unidade_administrativa_id = $('#unidade_administrativa_id').val();
        if(unidade_gestora_id)
            window.location.href = `/remanejamento?tipo=1&ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}&unidade_administrativa=${unidade_administrativa_id}`;
    });
    // remanejamento?ploa=2&unidade_gestora=1
  </script>
@endsection