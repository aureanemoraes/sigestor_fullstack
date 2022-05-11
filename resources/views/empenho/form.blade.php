<h3>Empenhos</h3>
<style>
  p {
    margin: 0;
  }
  
</style>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col">
          <p>
              <strong>Nº Da Certidão de Crédito</strong>
          </p>
          <p>
              {{ $certidao_credito->codigo_certidao }}
          </p>
      </div>
      <div class="col">
          <p>
              <strong>Data da Certidão de Crédito</strong>
          </p>
          <p>
              {{ formatDate($certidao_credito->created_at) }}
          </p>
      </div>
    </div>
      <div class="row">
          <div class="col">
              <p>
                  <strong>Unidade Gestora - UASG</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->uasg }}
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Unidade Gestora - SIGLA</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->unidade_gestora->sigla }}
              </p>
          </div>
      </div>
      <div class="row">
          <div class="col">
              <p>
                  <strong>Nº de solicitação</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->numero_solicitacao }}
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Código do processo</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->codigo_processo }}
              </p>
          </div>
      </div>
      <div class="row">
          <p>
              <strong>Despesa</strong>
          </p>
          <p>
              {{ $certidao_credito->credito_planejado->despesa->descricao }}
          </p>
      </div>
      <div class="row">
          <div class="col">
              <p>
                  <strong>Unidade Administrativa - UASG</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->unidade_administrativa->uasg }}
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Unidade Administrativa - SIGLA</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}
              </p>
          </div>
      </div>
      <div class="row">
          <div class="col">
              <p>
                  <strong>Programa</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->programa->nome }} 
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Fonte</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Natureza de despesa</strong>
              </p>
              <p>
                  {{ $certidao_credito->credito_planejado->despesa->natureza_despesa->nome_completo }}
              </p>
          </div>
          <div class="col">
              <p>
                  <strong>Valor</strong>
              </p>
              <p>
                  {{ formatCurrency($certidao_credito->credito_planejado->despesa->valor_total) }}
              </p>
          </div>
      </div>
  </div>
</div>

@php
    if(isset($empenho)) {
      $route = route('empenho.update', $empenho->id);
    } else {
      $route = route('empenho.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  <div class="form-group mb-3">
    <button type="button" class="btn btn-link" onClick="adicionarCampo('{{ isset($certidao_credito->empenho) && count($certidao_credito->empenho->notas_fiscais) > 0 ? json_encode($certidao_credito->empenho->notas_fiscais) : json_encode([]) }}')"><i class="bi bi-plus-circle-fill"></i> Adicionar nota fiscal</button>
  </div>

  <input type="hidden" name="certidao_credito_id" value={{ $certidao_credito->id }}>

  <input type="hidden" id="campos" value="{{ isset($certidao_credito->empenho) && count($certidao_credito->empenho->notas_fiscais) > 0? json_encode($certidao_credito->empenho->notas_fiscais) : null }}">

  <div class="notas_fiscais-container" id="notas_fiscais-container">
  </div>

  <button type="submit" class="btn btn-primary">Empenhar!</button>
</form>