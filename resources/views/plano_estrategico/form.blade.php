
<h3>Planos Estratégicos</h3>
@php
    if(isset($plano_estrategico)) {
      $route = route('plano_estrategico.update', $plano_estrategico->id);
    } else {
      $route = route('plano_estrategico.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($plano_estrategico))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($plano_estrategico->nome) ? $plano_estrategico->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ isset($plano_estrategico->data_inicio) ? dateToInput($plano_estrategico->data_inicio ): '' }}" placeholder="Sigla...">
    <label for="data_inicio">Ínicio</label>
    @error('data_inicio')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ isset($plano_estrategico->data_fim) ? dateToInput($plano_estrategico->data_fim) : '' }}" placeholder="Sigla...">
    <label for="data_fim">Fim</label>
    @error('data_fim')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('instituicao_id') is-invalid @enderror" id="instituicao_id" name="instituicao_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @foreach($instituicoes as $instituicao)
        @if(isset($plano_estrategico) && $instituicao->id == $plano_estrategico->instituicao_id)
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