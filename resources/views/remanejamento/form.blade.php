<h3>Remanejamentos</h3>
<style>
  p {
    margin: 0;
  }

  .form-control {
      display: inline;
  }

  .table {
      vertical-align: middle;
  }

  .filtro, .form-select {
      font-size: 0.75rem;
  }

  .select2-container{
      width: 100%!important;
    }
  
</style>
<h5>Despesa origem</h5>
<div class="card">
    <div class="card-body">
      <div class="table-responsive-sm table-loa">
          <form action="{{ route('remanejamento.store') }}" method="POST">
            @csrf
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td colspan="3">NATUREZA DE DESPESA: <strong>{{ $despesa_remetente->natureza_despesa->nome_completo }}</strong></td>
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
                                    <th>VALOR PARA REMANEJAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if($tipo == 1)
                                        <input type="hidden" name="unidade_gestora_id" value="{{ $despesa_remetente->ploa_administrativa->ploa_gestora->unidade_gestora_id }}">
                                    @elseif($tipo == 2)
                                        <input type="hidden" name="instituicao_id" value="{{ $despesa_remetente->ploa_administrativa->ploa_gestora->ploa->instituicao_id }}">
                                    @endif
                                    <td>{{ $despesa_remetente->descricao }}</td>
                                    <td>{{ $despesa_remetente->fonte }}</td>
                                    <td><input class="form-control" type="number" id="valor" name="valor" value="{{ $despesa_remetente->valor }}"></td> 
                                    <td>
                                        @if(isset($despesa_remetente->fields) && count($despesa_remetente->fields) > 0)
                                        @foreach($despesa_remetente->fields as $key => $field)
                                            <span>{{ $field['nome'] . ': ' }} <input class="form-control quantidades" type="number" id="{{ $key }}" name="fields[{{ $key }}][valor]" value="{{ $field['valor'] }}" max="{{ $field['valor'] }}"></span>
                                            <input class="form-control" type="hidden" name="fields[{{ $key }}][nome]" value="{{ $field['nome'] }}" ></span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        Inicial: {{ formatCurrency($despesa_remetente->valor_total) }} <br>
                                        Atual: <span id="valor-total-text">{{ formatCurrency($despesa_remetente->valor_total) }}</span>
                                    </td>
                                    <input type="hidden" id="valor-total-inicial" value="{{ $despesa_remetente->valor_total }}">
                                    <input type="hidden" id="valor-total" value="{{ $despesa_remetente->valor_total }}">
                                    <td>{{ $despesa_remetente->tipo }}</td>
                                    <td id="valor-remanejamento-text">
                                        R$ 00,00
                                    </td>
                                    <input type="hidden" name="valor_remanejamento" id="valor-remanejamento">
                                    <input type="hidden" name="despesa_remetente_id" value="{{ $despesa_remetente->id }}">
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group mb-2">
                <label for="numero_oficio">Número do ofício</label>
                <input class="form-control" type="text" name="numero_oficio" id="numero_oficio">
            </div>
            <div class="form-group mb-2">
                <label for="data">Data remanejo</label>
                <input class="form-control" type="date" name="data" id="data">
            </div>
            <button type="submit" class="btn btn-primary">Liberar recurso</button>
          </form>
      </div>
    </div>
</div>
{{-- <h5>Despesas destino</h5>
<input type="hidden" id="exercicio_id" value="{{ $despesa_remetente->exercicio_id}}">
<section class="filtro">
    <div class="row">
        <div class="col mb-1">
            <label for="unidade_administrativa_id">Unidade Administrativa</label>
            <select class="form-select"  id="unidade_administrativa_id" name="unidade_administrativa_id" aria-label="Selecione o grupo">
                <option selected value="">-- selecione --</option>
                @foreach($unidades_administrativas as $unidade_administrativa)
                    <option value="{{ $unidade_administrativa->id }}">
                        {{ $unidade_administrativa->nome_completo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mb-1">
            <label for="acao_tipo_id">Ação</label>
            <select class="form-select"  id="acao_tipo_id" name="acao_tipo_id" aria-label="Selecione o grupo">
                <option selected value="">-- selecione --</option>
            </select>
        </div>
        <div class="col mb-1">
            <label for="natureza_despesa_id">Natureza de despesa</label>
            <select class="form-select"  id="natureza_despesa_id" name="natureza_despesa_id" aria-label="Selecione o grupo">
                <option selected value="">-- selecione --</option>
            </select>
        </div>
    </div>
</section>
<section>
    <div class="table-responsive">
        <table class="table" id="despesas">
          <thead>
            <th>id</th>
            <th>descricao</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
</section> --}}
@php
    if(isset($remanejamento)) {
      $route = route('remanejamento.update', $remanejamento->id);
    } else {
      $route = route('remanejamento.store');
    }
@endphp
{{-- <form action="{{ $route }}" method="POST" id="form">
  @csrf
  <div class="form-group mb-3">
    <button type="button" class="btn btn-link" onClick="adicionarCampo('{{ isset($certidao_credito->empenho) && count($certidao_credito->empenho->notas_fiscais) > 0 ? json_encode($certidao_credito->empenho->notas_fiscais) : json_encode([]) }}')"><i class="bi bi-plus-circle-fill"></i> Adicionar nota fiscal</button>
  </div>

  <input type="hidden" name="certidao_credito_id" value={{ $certidao_credito->id }}>

  <input type="hidden" id="campos" value="{{ isset($certidao_credito->empenho) && count($certidao_credito->empenho->notas_fiscais) > 0? json_encode($certidao_credito->empenho->notas_fiscais) : null }}">

  <div class="notas_fiscais-container" id="notas_fiscais-container">
  </div>

  <button type="submit" class="btn btn-primary">Empenhar!</button>
</form> --}}