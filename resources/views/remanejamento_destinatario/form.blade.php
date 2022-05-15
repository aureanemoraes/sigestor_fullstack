<style>
  table, tr, td {
    vertical-align: middle;
  }
</style>

<h3>PLOA - {{ $exercicio->nome }} - UNIDADES GESTORAS</h3>
  <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">
  <input type="hidden" id="remanejamento_id" value="{{ $remanejamento->id }}">
  @include('loa_gestora.filtro-unidade-gestora', ['unidades_administrativas' => $unidades_administrativas])

  @if(isset($unidade_administrativa_selecionada))
  @else
    <div class="text-center">
      <p class="text-secondary">Selecione a unidade administrativa para remanejar valores.</p>
    </div>
  @endif

<h4>Detalhes do remanejamento</h4>
<div class="card">
  <div class="card-body">
    <div class="row d-flex justify-centent-center align-items-center">
      <div class="col">
          <strong>Nº Ofício: </strong> {{ $remanejamento->numero_oficio }}
      </div>
      <div class="col">
        <strong>Valor disponível: </strong> <span id="limite_remanejamento_text">{{ formatCurrency($remanejamento->valor_disponivel) }}</span>
        <input type="hidden" id="limite_remanejamento" value="{{ $remanejamento->valor_disponivel }}">
        <input type="hidden" id="limite_remanejamento_inicial" value="{{ $remanejamento->valor_disponivel }}">
        <input type="hidden" id="valor_remanejado" value=0>
      </div>
      <div class="col">
        <strong>Origem: </strong> {{ $remanejamento->despesa_remetente->ploa_administrativa->unidade_administrativa->unidade_gestora->nome_completo . '/' . $remanejamento->despesa_remetente->ploa_administrativa->unidade_administrativa->nome_completo}}
      </div>
    </div>
  </div>
</div>

<form action="{{ route('remanejamento_destinatario.store') }}" method="POST">
  @csrf
  <input type="hidden" name="remanejamento_id" value="{{ $remanejamento->id }}">
  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mb-3">Remanejar</button>
  </div>
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
                                            <th>VALOR REMANEJADO</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($natureza_despesa->despesas as $despesa)
                                              @if($despesa->ploa_administrativa->ploa_gestora->ploa->acao_tipo_id == $acao->id)
                                              <tr>
                                                <td>{{ $despesa->descricao }}</td>
                                                <td>{{ $despesa->fonte }}</td>
                                                <td><input class="form-control valor" type="number" id="valor-{{ $despesa->id }}" name="valor[{{ $despesa->id }}]" value="{{ $despesa->valor }}" min={{ $despesa->valor }}></td> 
                                                <td>
                                                    @if(isset($despesa->fields) && count($despesa->fields) > 0)
                                                    @foreach($despesa->fields as $key => $field)
                                                        <span>{{ $field['nome'] . ': ' }} <input class="form-control quantidades" type="number" id="{{ $key. '-'. $despesa->id }}" name="fields[{{ $despesa->id }}][{{ $key }}][valor]" value="{{ $field['valor'] }}" min="{{ $field['valor'] }}"></span>
                                                        <input class="form-control" type="hidden" name="fields[{{ $despesa->id }}][{{ $key }}][nome]" value="{{ $field['nome'] }}" ></span>
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    Inicial: {{ formatCurrency($despesa->valor_total) }} <br>
                                                    Atual: <span class="valor-total-text" id="valor-total-text-{{ $despesa->id }}">{{ formatCurrency($despesa->valor_total) }}</span>
                                                </td>
                                                <input type="hidden" class="valor-total-inicial" id="valor-total-inicial-{{ $despesa->id }}" value="{{ $despesa->valor_total }}">
                                                <input  class="valor-total" type="hidden" id="valor-total-{{ $despesa->id }}" value="{{ $despesa->valor_total }}">
                                                <td>{{ $despesa->tipo }}</td>
                                                <td id="valor-remanejamento-text-{{ $despesa->id }}">
                                                    R$ 00,00
                                                </td>
                                                <input class="valor_remanejamento" type="hidden" name="valor_remanejamento[{{ $despesa->id }}]" id="valor-remanejamento-{{ $despesa->id }}">
                                                <input type="hidden" name="despesas_ids[]" value="{{ $despesa->id }}">
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
  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary mb-3">Remanejar</button>
  </div>
</form>
