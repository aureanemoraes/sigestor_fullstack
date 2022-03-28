<h3>PLOA</h3>
@php
    if(isset($ploa)) {
      $route = route('ploa.update', $ploa->id);
    } else {
      $route = route('ploa.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($ploa))
    @method('PUT')
  @endif
 
  <div class="mb-3">
    <label for="exercicio_id">Exercício</label>
    <select class="form-select @error('exercicio_id') is-invalid @enderror" id="exercicio_id" name="exercicio_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($exercicios as $exercicios)
        @if(isset($ploa) && $exercicios->id == $ploa->exercicio_id)
          <option selected value="{{ $exercicios->id }}">{{ $exercicios->nome }}</option>
        @else
          <option value="{{ $exercicios->id }}">{{ $exercicios->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('exercicio_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="programa_id">Programa</label>
    <select class="form-control form-select @error('programa_id') is-invalid @enderror" id="programa_id" name="programa_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @if(isset($programas))
        @foreach($programas as $programa)
          @if(isset($ploa) && $programa->id == $plo->programa_id)
            <option selected value="{{ $programa->id }}">{{ $programa->nome }}</option>
          @else
            <option value="{{ $programa->id }}">{{ $programa->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('programa_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="fonte_tipo_id">Fonte</label>
    <select class="form-control form-select @error('fonte_tipo_id') is-invalid @enderror" id="fonte_tipo_id" name="fonte_tipo_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @if(isset($fontes))
        @foreach($fontes as $fonte)
          @if(isset($ploa) && $fonte->id == $ploa->fonte_tipo_id)
            <option selected value="{{ $fonte->id }}">{{ $fonte->codigo . ' - ' . $fonte->nome }}</option>
          @else
            <option value="{{ $fonte->id }}">{{ $fonte->codigo . ' - ' . $fonte->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('fonte_tipo_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="acao_tipo_id">Ação</label>
    <select class="form-control form-select @error('acao_tipo_id') is-invalid @enderror" id="acao_tipo_id" name="acao_tipo_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @if(isset($acoes))
        @foreach($acoes as $acao)
          @if(isset($ploa) && $acao->id == $ploa->acao_tipo_id)
            <option selected value="{{ $acao->id }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
          @else
            <option value="{{ $acao->id }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('acao_tipo_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group mb-3">
    <label for="tipo_acao">Tipo de despesa</label>
    <select class="form-control form-select @error('tipo_acao') is-invalid @enderror" id="tipo_acao" name="tipo_acao" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
    </select>
    @error('tipo_acao')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group mb-3">
    <label for="tipo_acao">Instituição</label>
    <select class="form-control form-select @error('tipo_acao') is-invalid @enderror" id="tipo_acao" name="tipo_acao" aria-label="Selecione a instituição">
      @foreach($instituicoes as $instituicao)
        @if(isset($ploa) && $instituicao->id == $ploa->tipo_acao)
          <option selected value="{{ $instituicao->id }}">{{ $instituicao->nome }}</option>
        @else
          <option value="{{ $instituicao->id }}">{{ $instituicao->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('tipo_acao')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="ativo" id="ativo" {{ isset($ploa->ativo) && $ploa->ativo ? 'checked' : '' }} value="1">
      <label class="form-check-label" for="ativo">
        Ativo
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="ativo" id="inativo" {{ isset($ploa->ativo) && !$ploa->ativo ? 'checked' : '' }} value="0">
      <label class="form-check-label" for="inativo">
        Inativo
      </label>
    </div>
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>