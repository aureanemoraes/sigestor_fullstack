
<h3>Ações</h3>
@php
    if(isset($acao_tipo)) {
      $route = route('acao_tipo.update', $acao_tipo->id);
    } else {
      $route = route('acao_tipo.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($acao_tipo))
    @method('PUT')
  @endif

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ isset($acao_tipo->codigo) ? $acao_tipo->codigo : ''}}" placeholder="Nome...">
    <label for="codigo">Código</label>
    @error('codigo')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($acao_tipo->nome) ? $acao_tipo->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome_simplificado') is-invalid @enderror" id="nome_simplificado" name="nome_simplificado" value="{{ isset($acao_tipo->nome_simplificado) ? $acao_tipo->nome_simplificado : ''}}" placeholder="Nome...">
    <label for="nome_simplificado">Nome simplificado</label>
    @error('nome_simplificado')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group mb-3">
    <label>Tipos de despesas</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="custeio" name="custeio" {{ isset($acao_tipo->custeio) && $acao_tipo->custeio ? 'checked' : '' }}>
      <label class="form-check-label" for="custeio">
        Custeio
      </label>
    </div>
  
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" id="investimento" name="investimento" {{ isset($acao_tipo->investimento) && $acao_tipo->investimento ? 'checked' : '' }}>
      <label class="form-check-label" for="investimento">
        Investimento
      </label>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
