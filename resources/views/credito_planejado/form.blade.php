<h3>Créditos Planejados</h3>
@php
    if(isset($credito_planejado)) {
      $route = route('credito_planejado.update', $credito_planejado->id);
    } else {
      $route = route('credito_planejado.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($credito_planejado))
    @method('PUT')
  @endif

    <div class="card">
        <div class="card-body">
        <div class="table-responsive table-responsive-sm">
            <table class="table table-sm">
            <thead>
                <th>NATUREZA DE DESPESA</th>
                <th>DESPESA</th>
                <th>FONTE</th>
                <th>VALOR DISPONÍVEL</th>
            </thead>
            <tbody>
                <td>{{ $despesa->natureza_despesa->nome_completo }}</td>
                <td>{{ $despesa->descricao }}</td>
                <td>{{ $despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}</td>
                <td>{{ formatCurrency($despesa->valor_disponivel) }}</td>
            </tbody>
            </table>
        </div>
        </div>
    </div>

    <input type="hidden" name="despesa_id" value={{ $despesa->id }}>

    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('codigo_processo') is-invalid @enderror" id="codigo_processo" name="codigo_processo" value="{{ isset($credito_planejado->codigo_processo) ? $credito_planejado->codigo_processo : null}}" placeholder="Nome..." {{ isset($credito_planejado->credito_planejado_modelo_id) ? 'readonly' : '' }}>
        <label for="codigo_processo">Código do processo</label>
        @error('codigo_processo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form-floating mb-3">
      <input type="number" class="form-control @error('valor_solicitado') is-invalid @enderror" id="valor_solicitado" name="valor_solicitado" value="{{ isset($credito_planejado->valor_solicitado) ? $credito_planejado->valor_solicitado : null}}" placeholder="Nome..." {{ isset($credito_planejado->credito_planejado_modelo_id) ? 'readonly' : '' }}>
      <label for="valor_solicitado">Valor solicitado</label>
      @error('valor_solicitado')
      <div class="invalid-feedback">
          {{ $message }}
      </div>
      @enderror
  </div>

  <div class="fields-container" id="fields-container">
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
