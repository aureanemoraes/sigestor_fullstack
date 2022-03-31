<style>
  .subtitle-new {
    background: green;
    padding: 0.2rem;
    color: white;
    border-radius: 0.5rem;
  }

  .subtitle-edit {
    background: yellowgreen;
    padding: 0.2rem;
    color: white;
    border-radius: 0.5rem;
  }
</style>
<div>
  <p><span class="title">PLOA</span> - <span class="subtitle-new" id="subtitle">Novo</span></p>
</div>
@php
    if(isset($ploa_gestora)) {
      $route = route('ploa_gestora.update', $ploa_gestora->id);
    } else {
      $route = route('ploa_gestora.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($ploa_gestora))
    @method('PUT')
  @endif

  <div class="row">
    <div class="mb-3 col-4">
      <label for="programa_id">Programa</label>
      <select class="form-control form-select @error('programa_id') is-invalid @enderror" id="programa_id" name="programa_id" aria-label="Selecione a instituição">
        <option selected value="">-- selecione --</option>
        @if(isset($programas))
          @foreach($programas as $programa)
            @if(isset($ploa_gestora) && $programa->id == $plo->programa_id)
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

    <div class="mb-3 col-4">
      <label for="fonte_tipo_id">Fonte</label>
      <select class="form-control form-select @error('fonte_tipo_id') is-invalid @enderror" id="fonte_tipo_id" name="fonte_tipo_id" aria-label="Selecione a instituição">
        <option selected value="">-- selecione --</option>
        @if(isset($fontes))
          @foreach($fontes as $fonte)
            @if(isset($ploa_gestora) && $fonte->id == $ploa_gestora->fonte_tipo_id)
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

    <div class="mb-3 col-4">
      <label for="acao_tipo">Ação</label>
      <select class="form-control form-select @error('acao_tipo_id') is-invalid @enderror" id="acao_tipo" aria-label="Selecione a instituição">
        <option selected value="">-- selecione --</option>
        @if(isset($acoes))
          @foreach($acoes as $acao)
            @if(isset($ploa_gestora) && $acao->id == $ploa_gestora->acao_tipo_id)
              <option selected value="{{ $acao }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
            @else
              <option value="{{ $acao }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
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
  </div>

  <div class="row">
    <input type="hidden" name="acao_tipo_id" id="acao_tipo_id" value="{{ isset($ploa_gestora) ? $ploa_gestora->acao_tipo_id : '' }}">

    <input type="hidden" name="exercicio_id" id="exercicio" value="{{ isset($ploa_gestora) ? $ploa_gestora->exercicio_id : '' }}">

    <input type="hidden" name="unidade_gestora_id" id="unidade_gestora" value="{{ isset($ploa_gestora) ? $ploa_gestora->unidade_gestora_id : '' }}">

    <div class="form-group mb-3 col-4">
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
  
    <div class="form-group mb-3 col-4">
      <label for="instituicao_id">Instituição</label>
      <select class="form-control form-select @error('instituicao_id') is-invalid @enderror" id="instituicao_id" name="instituicao_id" aria-label="Selecione a instituição">
        @foreach($instituicoes as $instituicao)
          @if(isset($ploa_gestora) && $instituicao->id == $ploa_gestora->instituicao_id)
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

    <div class="form-group mb-3 col-4">
      <label for="valor">Valor</label>
      <input type="number" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ isset($ploa_gestora->valor) ? $ploa_gestora->valor : null}}" placeholder="R$ 00,00">
      @error('valor')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  
  <div class="btn-group btn-group-sm float-end" role="group" id="buttons-form">
    <button type="button" class="btn btn-warning" style="display: none;" id="cancel-button">Cancelar</button>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </div>
</form>