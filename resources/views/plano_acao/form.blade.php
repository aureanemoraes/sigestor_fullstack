
<h3>Planos de Ações</h3>
@php
    if(isset($plano_acao)) {
      $route = route('plano_acao.update', $plano_acao->id);
    } else {
      $route = route('plano_acao.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($plano_acao))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($plano_acao->nome) ? $plano_acao->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ isset($plano_acao->data_inicio) ? dateToInput($plano_acao->data_inicio ): '' }}" placeholder="Sigla...">
    <label for="data_inicio">Ínicio</label>
    @error('data_inicio')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ isset($plano_acao->data_fim) ? dateToInput($plano_acao->data_fim) : '' }}" placeholder="Sigla...">
    <label for="data_fim">Fim</label>
    @error('data_fim')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="plano_estrategico_id">Plano Estratégico</label>
    <select class="form-select @error('plano_estrategico_id') is-invalid @enderror" id="plano_estrategico_id" name="plano_estrategico_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($planos_estrategicos as $plano_estrategico)
        @if(isset($plano_acao) && $plano_estrategico->id == $plano_acao->plano_estrategico_id)
          <option selected value="{{ $plano_estrategico->id }}">{{ $plano_estrategico->nome }}</option>
        @else
          <option value="{{ $plano_estrategico->id }}">{{ $plano_estrategico->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('plano_estrategico_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <select class="form-control form-select @error('instituicao_id') is-invalid @enderror" id="instituicao_id" name="instituicao_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @foreach($instituicoes as $instituicao)
        @if(isset($plano_acao) && $instituicao->id == $plano_acao->instituicao_id)
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