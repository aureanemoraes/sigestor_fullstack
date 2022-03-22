
<h3>Unidades Administrativas</h3>
@php
    if(isset($unidade_administrativa)) {
      $route = route('unidade_administrativa.update', $unidade_administrativa->id);
    } else {
      $route = route('unidade_administrativa.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($unidade_administrativa))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($unidade_administrativa->nome) ? $unidade_administrativa->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('sigla') is-invalid @enderror" id="sigla" name="sigla" value="{{ isset($unidade_administrativa->sigla) ? $unidade_administrativa->sigla : '' }}" placeholder="Sigla...">
    <label for="sigla">Sigla</label>
    @error('sigla')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('uasg') is-invalid @enderror" id="uasg" name="uasg" value="{{ isset($unidade_administrativa->uasg) ? $unidade_administrativa->uasg : '' }}" placeholder="Ugr...">
    <label for="uasg">Uasg</label>
    @error('uasg')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('instituicao_id') is-invalid @enderror" id="instituicao_id" name="instituicao_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @foreach($instituicoes as $instituicao)
        @if(isset($unidade_administrativa) && $instituicao->id == $unidade_administrativa->instituicao_id)
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
  
  <div class="form-floating mb-3">
    <select class="form-control form-select @error('unidade_gestora_id') is-invalid @enderror" id="unidade_gestora_id" name="unidade_gestora_id" aria-label="Selecione a unidade gestora">
      <option selected value="">-- selecione --</option>
      @foreach($unidades_gestoras as $unidade_gestora)
        @if(isset($unidade_administrativa) && $unidade_gestora->id == $unidade_administrativa->unidade_gestora_id)
          <option selected value="{{ $unidade_gestora->id }}">{{ $unidade_gestora->nome }}</option>
        @else
          <option value="{{ $unidade_gestora->id }}">{{ $unidade_gestora->nome }}</option>
        @endif
      @endforeach
    </select>
    <label for="unidade_gestora_id">Unidade Gestora</label>
    @error('unidade_gestora_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>