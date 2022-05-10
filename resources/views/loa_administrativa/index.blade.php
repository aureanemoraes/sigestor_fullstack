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
    @php
        use App\Models\NaturezaDespesa;
        use App\Models\Programa;
    @endphp
    <h3>PLOA - {{ $exercicio->nome }} - UNIDADES ADMINISTRATIVAS</h3>
    @include('loa_administrativa.filtro-unidade-administrativa')
    <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">
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
            <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($limite_planejado) }}</p>
        </div>
          @foreach($acoes as $acao)
            <h6>{{ $acao->nome_completo }}</h6>
            @foreach($naturezas_despesas as $natureza_despesa)
                <div class="card">
                    <div class="card-body">
                      <div class="table-responsive-sm table-loa">
                          <table class="table table-sm">
                              @if(count($natureza_despesa->despesas) > 0)
                                  @php
                                      $valores_natureza = NaturezaDespesa::valores($natureza_despesa, $acao->id, $exercicio->id, $unidade_selecionada->id);
                                  @endphp
                                  <tbody>
                                      <tr>
                                          <td colspan="2">NATUREZA DE DESPESA: <strong>{{ $natureza_despesa->nome_completo }}</strong></td>
                                          <th>VALOR PLOA</th>
                                          <th>TOTAL LIMITE RECEBIDO</th>
                                          <th>A RECEBER</th>
                                          <th></th>
                                      </tr>
                                      <tr>
                                          <td colspan="2">Total estimado</td>
                                          <th>{{ formatCurrency($valores_natureza['valor_total']) }}</th>
                                          <th>{{ formatCurrency($valores_natureza['total_limite_recebido']) }}</th>
                                          <th>{{ formatCurrency($valores_natureza['a_receber']) }}</th>
                                          <th></th>
                                      </tr>
                                      <tr>
                                      <td colspan="6">
                                          <table class="table mb-0 table-sm">
                                              <thead>
                                                  <tr>
                                                      <th>DESPESA</th>
                                                      <th>FONTE</th>
                                                      <th>VALOR TOTAL</th>
                                                      <th></th>
                                                      <th></th>
                                                      <th></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  @foreach($natureza_despesa->despesas as $despesa)
                                                      @if($despesa->ploa_administrativa->ploa_gestora->ploa->acao_tipo_id == $acao->id)
                                                      <tr>
                                                        <td>{{ $despesa->descricao }}</td>
                                                        <td>{{ $despesa->fonte }}</td>
                                                        <td>{{ formatCurrency($despesa->valor_total) }}</td>
                                                        <td>{{ formatCurrency($despesa->valor_recebido) }}</td>
                                                        <td>{{ formatCurrency($despesa->valor_disponivel) }}</td>
                                                        <td>
                                                          <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                                                            @if($despesa->possui_solicitacao_credito_pendente)
                                                              <button type="button" disabled class="btn btn-primary" >Solicitar cerditão de crédito</button>
                                                            @else
                                                              <a type="button" href="{{ route('credito_planejado.create', ['despesa' => $despesa->id]) }}" class="btn btn-primary" >Solicitar cerditão de crédito</a>
                                                            @endif
                                                            
                                                            <a type="button" href="{{ route('credito_planejado.lista', $despesa->id) }}" class="btn btn-primary" >Ver solicitações de crédito</a>
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
    </section>
    @endif
    
@endsection

@section('js')
    <script>
        $('#unidade_administrativa_id').on('change', () => {
            let exercicio_id = $('#exercicio_id').val();
            let unidade_administrativa_id = $('#unidade_administrativa_id').val();
            if(unidade_administrativa_id)
                window.location.href = `/loa_administrativa?ploa=${exercicio_id}&unidade_administrativa=${unidade_administrativa_id}`;
            else
                window.location.href = `/loa_administrativa?ploa=${exercicio_id}`;
        });

        $(function() {
            $('#unidade_administrativa_id').select2();
        })
    </script>
@endsection