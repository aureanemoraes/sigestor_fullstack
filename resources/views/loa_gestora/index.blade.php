@extends('layouts.app')

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
    @php
    use App\Models\Ploa;
    use App\Models\Programa;
    @endphp
    <h3>PLOA - {{ $exercicio->nome }} - UNIDADES GESTORAS</h3>
    <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">

    @include('loa_gestora.filtro-unidade-gestora')

    @if(isset($unidade_selecionada))
      <section class="distribuicao-resumo">
        <div class="table-responsive table-responsive-sm">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>LIMITE PLANEJADO</th>
                <th>LIMITE RECEBIDO</th>
                <th>LIMITE A RECEBER</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ formatCurrency($limite_planejado) }}</td>
                <td>{{ formatCurrency($limite_recebido) }}</td>
                <td>{{ formatCurrency($limite_a_receber) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <section>
        <div class="d-flex justify-content-end ">
            <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($total_ploa) }}</p>
        </div>
        @foreach($programas_ploa as $programa)
          <div class="card">
              <div class="card-body">
              <div class="table-responsive-sm table-loa">
                  <table class="table table-sm">
                      @if(count($programa->ploas) > 0)
                      @php
                          $valores_programa = Programa::valores($programa, 'ploa_gestora', $unidade_selecionada->id, $exercicio->id);
                      @endphp
                      <tbody>
                          <tr>
                              <td colspan="3">Programa: <strong>{{ Str::upper($programa->nome) }}</strong></td>
                              <th>VALOR PLOA</th>
                              <th>TOTAL LIMITE RECEBIDO</th>
                              <th>A RECEBER</th>
                              <th></th>
                          </tr>
                          <tr>
                              <td colspan="3">Total estimado</td>
                              <th>{{ formatCurrency($valores_programa['valor_total']) }} </th>
                              <th>{{ formatCurrency($valores_programa['valor_recebido']) }}</th>
                              <th>{{ formatCurrency($valores_programa['valor_a_receber']) }}</th>
                              <th></th>
                          </tr>
                          <tr>
                          <td colspan="7">
                              <table class="table mb-0 table-sm">
                                  <thead>
                                      <tr>
                                          <th>Ação</th>
                                          <th>Tipo</th>
                                          <th>Fonte</th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($ploas_gestoras as $ploa_gestora)
                                    @if($ploa_gestora->ploa->programa_id == $programa->id)
                                      @php
                                        // $valores_ploa_gestora = PloaGestora::valores($ploa_gestora);
                                      @endphp
                                    <tr>
                                      <td>{{ $ploa_gestora->ploa->acao_tipo->codigo . ' - ' . $ploa_gestora->ploa->acao_tipo->nome }}</td>
                                      <td>{{ ucfirst($ploa_gestora->ploa->tipo_acao) }}</td>
                                      <td>{{ $ploa_gestora->ploa->fonte_tipo->codigo }}</td>
                                      <td>{{ formatCurrency($ploa_gestora->valor) }}</td>
                                      <td>
                                        aa
                                      </td>
                                      <td>
                                        bb
                                      </td>
                                      <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                                          <a type="button" href="{{ route('credito_planejado.index', ['ploa_gestora' => $ploa_gestora->id]) }}" class="btn btn-primary" ><i class="bi bi-list-nested"></i></a>
                                          @if(isset($ploa_gestora->solicitacao_credito_planejado))
                                            {{-- {{ $ploa_gestora->solicitacao_credito_planejado }} --}}
                                          @endif
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
      </section>
    @endif
@endsection

@section('js')
    <script>
        $('#unidade_gestora_id').on('change', () => {
            let exercicio_id = $('#exercicio_id').val();
            let unidade_gestora_id = $('#unidade_gestora_id').val();
            if(unidade_gestora_id)
                window.location.href = `/loa_gestora?ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}`;
            else
                window.location.href = `/loa_gestora?ploa=${exercicio_id}`;
        });

        $(function() {
            $('#unidade_gestora_id').select2();
        })
    </script>
@endsection