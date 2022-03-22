
<h3>Eixos Estratégicos</h3>
@php
    if(isset($eixo_estrategico)) {
      $route = route('eixo_estrategico.update', $eixo_estrategico->id);
    } else {
      $route = route('eixo_estrategico.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($eixo_estrategico))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($eixo_estrategico->nome) ? $eixo_estrategico->nome : ''}}" placeholder="Nome...">
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
        @if(isset($eixo_estrategico) && $plano_estrategico->id == $eixo_estrategico->plano_estrategico_id)
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
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>