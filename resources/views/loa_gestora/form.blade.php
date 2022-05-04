<h3>Movimentos</h3>
@php
    if(isset($loa_gestora)) {
      $route = route('loa_gestora.update', $loa_gestora->id);
    } else {
      $route = route('loa_gestora.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($loa_gestora))
    @method('PUT')
  @endif

  <div class="card">
    <div class="card-body">
      <div class="table-responsive table-responsive-sm">
        <table class="table table-sm">
          <thead>
            <th>LOA</th>
            <th>AÇÃO</th>
            <th>TIPO</th>
            <th>FONTE</th>
            <th>VALOR PLANEJADO</th>
          </thead>
          <tbody>
            <td>{{ $ploa_gestora->ploa->exercicio->nome }}</td>
            <td>{{ $ploa_gestora->ploa->acao_tipo->nome_completo }}</td>
            <td>{{ $ploa_gestora->ploa->tipo_acao }}</td>
            <td>{{ $ploa_gestora->ploa->fonte_tipo->codigo }}</td>
            <td>{{ formatCurrency($ploa_gestora->valor) }}</td>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="form-floa_gestorating mb-3">
    <textarea class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" id="descricao" name="descricao">{{ isset($loa_gestora->descricao) ? $loa_gestora->descricao : '' }}</textarea>
    <label for="floa_gestoratingTextarea">Descrição</label>
    @error('descricao')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floa_gestorating mb-3">
    <input type="date" class="form-control @error('data_recebimento') is-invalid @enderror" id="data_recebimento" name="data_recebimento" value="{{ isset($loa_gestora->data_recebimento) ? $loa_gestora->data_recebimento : null}}" placeholder="Nome...">
    <label for="data_recebimento">Data de recebimento</label>
    @error('data_recebimento')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floa_gestorating mb-3">
    <input type="number" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ isset($loa_gestora->valor) ? $loa_gestora->valor : null}}" placeholder="Nome...">
    <label for="valor">Valor</label>
    @error('valor')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <input type="hidden" name="ploa_gestora_id" value="{{ $ploa_gestora->id }}">

  <div class="form-floa_gestorating mb-3">
    <select class="form-control form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      <option value="entrada" {{ isset($loa_gestora->tipo) && $loa_gestora->tipo == 'entrada' ? 'selected' : ''  }}>
        Entrada
      </option>
      <option value="bloqueio" {{ isset($loa_gestora->tipo) && $loa_gestora->tipo == 'bloqueio' ? 'selected' : ''  }}>
        Bloqueio
      </option>
    </select>
    <label for="tipo">Tipo</label>
    @error('tipo')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
