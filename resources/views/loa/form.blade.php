<h3>Movimentos</h3>
@php
    if(isset($loa)) {
      $route = route('loa.update', $loa->id);
    } else {
      $route = route('loa.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($loa))
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
            <td>{{ $ploa->exercicio->nome }}</td>
            <td>{{ $ploa->acao_tipo->nome_completo }}</td>
            <td>{{ $ploa->tipo_acao }}</td>
            <td>{{ $ploa->fonte_tipo->codigo }}</td>
            <td>{{ formatCurrency($ploa->valor) }}</td>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="form-floating mb-3">
    <textarea class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" id="descricao" name="descricao">{{ isset($loa->descricao) ? $loa->descricao : '' }}</textarea>
    <label for="floatingTextarea">Descrição</label>
    @error('descricao')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_recebimento') is-invalid @enderror" id="data_recebimento" name="data_recebimento" value="{{ isset($loa->data_recebimento) ? $loa->data_recebimento : null}}" placeholder="Nome...">
    <label for="data_recebimento">Data de recebimento</label>
    @error('data_recebimento')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="number" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ isset($loa->valor) ? $loa->valor : null}}" placeholder="Nome...">
    <label for="valor">Valor</label>
    @error('valor')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <input type="hidden" name="ploa_id" value="{{ $ploa->id }}">

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      <option value="entrada" {{ isset($loa->tipo) && $loa->tipo == 'entrada' ? 'selected' : ''  }}>
        Entrada
      </option>
      <option value="bloqueio" {{ isset($loa->tipo) && $loa->tipo == 'bloqueio' ? 'selected' : ''  }}>
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
