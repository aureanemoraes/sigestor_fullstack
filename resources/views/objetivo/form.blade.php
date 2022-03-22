
<h3>Objetivos Estratégicos</h3>
@php
    if(isset($objetivo)) {
      $route = route('objetivo.update', $objetivo->id);
    } else {
      $route = route('objetivo.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($objetivo))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($objetivo->nome) ? $objetivo->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
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
        @if(isset($objetivo) && $plano_estrategico->id == $objetivo->dimensao->eixo_estrategico->plano_estrategico_id)
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

  <div class="mb-3">
    <label for="eixo_estrategico_id">Eixo Estratégico</label>
    <select class="form-control form-select @error('eixo_estrategico_id') is-invalid @enderror" id="eixo_estrategico_id" name="eixo_estrategico_id" aria-label="Selecione a instituição">
      @if(isset($eixos_estrategicos))
        @foreach($eixos_estrategicos as $eixo_estrategico)
          @if(isset($objetivo) && $eixo_estrategico->id == $objetivo->dimensao->eixo_estrategico_id)
            <option selected value="">-- selecione --</option>
            <option selected value="{{ $eixo_estrategico->id }}">{{ $eixo_estrategico->nome }}</option>
          @else
            <option value="{{ $eixo_estrategico->id }}">{{ $eixo_estrategico->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('eixo_estrategico_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="dimensao_id">Dimensão Estratégica</label>
    <select class="form-control form-select @error('dimensao_id') is-invalid @enderror" id="dimensao_id" name="dimensao_id" aria-label="Selecione a instituição">
      @if(isset($dimensoes))
        @foreach($dimensoes as $dimensao)
          @if(isset($objetivo) && $dimensao->id == $objetivo->dimensao_id)
            <option selected value="">-- selecione --</option>
            <option selected value="{{ $dimensao->id }}">{{ $dimensao->nome }}</option>
          @else
            <option value="{{ $dimensao->id }}">{{ $dimensao->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('dimensao_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  <div class="mb-3">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="ativo" id="ativo" {{ isset($objetivo->ativo) && $objetivo->ativo ? 'checked' : '' }} value="1">
      <label class="form-check-label" for="ativo">
        Ativo
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="ativo" id="inativo" {{ isset($objetivo->ativo) && !$objetivo->ativo ? 'checked' : '' }} value="0">
      <label class="form-check-label" for="inativo">
        Inativo
      </label>
    </div>
  </div>
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>