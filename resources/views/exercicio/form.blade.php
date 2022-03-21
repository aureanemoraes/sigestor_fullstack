
<h3>Exercícios</h3>
@php
    if(isset($exercicio)) {
      $route = route('exercicio.update', $exercicio->id);
    } else {
      $route = route('exercicio.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($exercicio))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($exercicio->nome) ? $exercicio->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ isset($exercicio->data_inicio) ? dateToInput($exercicio->data_inicio ): '' }}" placeholder="Sigla...">
    <label for="data_inicio">Ínicio</label>
    @error('data_inicio')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ isset($exercicio->data_fim) ? dateToInput($exercicio->data_fim) : '' }}" placeholder="Sigla...">
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
        @if(isset($exercicio) && $instituicao->id == $exercicio->instituicao_id)
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