
<h3>Fontes</h3>
@php
    if(isset($fonte_tipo)) {
      $route = route('fonte_tipo.update', $fonte_tipo->id);
    } else {
      $route = route('fonte_tipo.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($fonte_tipo))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($fonte_tipo->nome) ? $fonte_tipo->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="grupo_fonte_id">Grupo</label>
    <select class="form-select @error('grupo_fonte_id') is-invalid @enderror" id="grupo_fonte_id" name="grupo_fonte_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($grupos_fontes as $grupo_fonte)
        @if(isset($fonte_tipo) && $grupo_fonte->id == $fonte_tipo->grupo_fonte_id)
          <option selected value="{{ $grupo_fonte->id }}">{{ $grupo_fonte->id . ' - ' . $grupo_fonte->nome }}</option>
        @else
          <option value="{{ $grupo_fonte->id }}">{{ $grupo_fonte->id . ' - ' . $grupo_fonte->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('grupo_fonte_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="especificacao_id">Especificacao</label>
    <select class="form-select @error('especificacao_id') is-invalid @enderror" id="especificacao_id" name="especificacao_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($especificacoes as $especificacao)
        @if(isset($fonte_tipo) && $especificacao->id == $fonte_tipo->especificacao_id)
          <option selected value="{{ $especificacao->id }}">{{ $especificacao->id_formatado . ' - ' . $especificacao->nome }}</option>
        @else
          <option value="{{ $especificacao->id }}">{{ $especificacao->id_formatado . ' - ' . $especificacao->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('especificacao_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
