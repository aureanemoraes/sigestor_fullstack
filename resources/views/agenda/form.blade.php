
<h3>Agendas</h3>
@php
    if(isset($agenda)) {
      $route = route('agenda.update', $agenda->id);
    } else {
      $route = route('agenda.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($agenda))
    @method('PUT')
  @endif
  <div class="mb-3">
    <label for="plano_estrategico_id">Exercício</label>
    <select class="form-select"  id="exercicio_id" name="exercicio_id" aria-label="Selecione o grupo">
        @if(isset($exercicio))
          <option selected value="{{ $exercicio->id }}">{{ $exercicio->nome }}</option>
        @endif
    </select>
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($agenda->nome) ? $agenda->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ isset($agenda->data_inicio) ? dateToInput($agenda->data_inicio ): '' }}" placeholder="Sigla...">
    <label for="data_inicio">Ínicio</label>
    @error('data_inicio')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ isset($agenda->data_fim) ? dateToInput($agenda->data_fim) : '' }}" placeholder="Sigla...">
    <label for="data_fim">Fim</label>
    @error('data_fim')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>