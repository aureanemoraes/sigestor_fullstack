
<h3>Unidades Gestoras</h3>
@php
    if(isset($unidade_gestora)) {
      $route = route('unidade_gestora.update', $unidade_gestora->id);
    } else {
      $route = route('unidade_gestora.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($unidade_gestora))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($unidade_gestora->nome) ? $unidade_gestora->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('sigla') is-invalid @enderror" id="sigla" name="sigla" value="{{ isset($unidade_gestora->sigla) ? $unidade_gestora->sigla : '' }}" placeholder="Sigla...">
    <label for="sigla">Sigla</label>
    @error('sigla')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('cnpj') is-invalid @enderror" id="cnpj" name="cnpj" value="{{ isset($unidade_gestora->cnpj) ? $unidade_gestora->cnpj : '' }}" placeholder="Cnpj...">
    <label for="cnpj">Cnpj</label>
    @error('cnpj')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('uasg') is-invalid @enderror" id="uasg" name="uasg" value="{{ isset($unidade_gestora->uasg) ? $unidade_gestora->uasg : '' }}" placeholder="Uasg...">
    <label for="uasg">Uasg</label>
    @error('uasg')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ isset($unidade_gestora->logradouro) ? $unidade_gestora->logradouro : '' }}" placeholder="Logradouro...">
    <label for="logradouro">Logradouro</label>
    @error('logradouro')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ isset($unidade_gestora->numero) ? $unidade_gestora->numero : '' }}" placeholder="Número...">
    <label for="numero">Número</label>
    @error('numero')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ isset($unidade_gestora->bairro) ? $unidade_gestora->bairro : '' }}" placeholder="Bairro...">
    <label for="bairro">Bairro</label>
    @error('bairro')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ isset($unidade_gestora->complemento) ? $unidade_gestora->complemento : '' }}" placeholder="Complemento...">
    <label for="complemento">Complemento</label>
    @error('complemento')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('instituicao_id') is-invalid @enderror" id="instituicao_id" name="instituicao_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @foreach($instituicoes as $instituicao)
        @if(isset($unidade_gestora) && $instituicao->id == $unidade_gestora->instituicao_id)
          <option selected value="{{ $instituicao->id }}">{{ $instituicao->nome }}</option>
        @else
          <option value="{{ $instituicao->id }}">{{ $instituicao->nome }}</option>
        @endif
      @endforeach
    </select>
    <label for="instituicao_id">Instituição</label>
    @error('instituicao_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>