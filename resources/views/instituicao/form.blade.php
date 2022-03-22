
<h3>Instituições</h3>
@php
    if(isset($instituicao)) {
      $route = route('instituicao.update', $instituicao->id);
    } else {
      $route = route('instituicao.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($instituicao))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($instituicao->nome) ? $instituicao->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('sigla') is-invalid @enderror" id="sigla" name="sigla" value="{{ isset($instituicao->sigla) ? $instituicao->sigla : '' }}" placeholder="Sigla...">
    <label for="sigla">Sigla</label>
    @error('sigla')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('cnpj') is-invalid @enderror" id="cnpj" name="cnpj" value="{{ isset($instituicao->cnpj) ? $instituicao->cnpj : '' }}" placeholder="Cnpj...">
    <label for="cnpj">Cnpj</label>
    @error('cnpj')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('ugr') is-invalid @enderror" id="ugr" name="ugr" value="{{ isset($instituicao->ugr) ? $instituicao->ugr : '' }}" placeholder="Uasg...">
    <label for="ugr">Ugr</label>
    @error('ugr')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ isset($instituicao->logradouro) ? $instituicao->logradouro : '' }}" placeholder="Logradouro...">
    <label for="logradouro">Logradouro</label>
    @error('logradouro')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ isset($instituicao->numero) ? $instituicao->numero : '' }}" placeholder="Número...">
    <label for="numero">Número</label>
    @error('numero')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ isset($instituicao->bairro) ? $instituicao->bairro : '' }}" placeholder="Bairro...">
    <label for="bairro">Bairro</label>
    @error('bairro')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ isset($instituicao->complemento) ? $instituicao->complemento : '' }}" placeholder="Complemento...">
    <label for="complemento">Complemento</label>
    @error('complemento')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>