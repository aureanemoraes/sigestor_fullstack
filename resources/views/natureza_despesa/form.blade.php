
<h3>Naturezas de Despesas</h3>
@php
    if(isset($natureza_despesa)) {
      $route = route('natureza_despesa.update', $natureza_despesa->id);
    } else {
      $route = route('natureza_despesa.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($natureza_despesa))
    @method('PUT')
  @endif

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ isset($natureza_despesa->codigo) ? $natureza_despesa->codigo : ''}}" placeholder="Nome...">
    <label for="codigo">Código</label>
    @error('codigo')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($natureza_despesa->nome) ? $natureza_despesa->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group mb-3">
    <label for="tipo">Tipos</label>
    <select class="form-select" aria-label="Tipo" id="tipo" name="tipo">
      <option selected value="">-- selecione --</option>
      <option value="custeio">Custeio</option>
      <option value="investimento">Investimento</option>
    </select>
  </div>

  <div class="form-group mb-3">
    <button type="button" class="btn btn-link" onClick='adicionarCampo({{ isset($natureza_despesa->fields) ? json_encode($natureza_despesa->fields) : json_encode([]) }})'><i class="bi bi-plus-circle-fill"></i> Adicionar campo</button>
  </div>

  <div class="campos-container" id="campos-container">
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
