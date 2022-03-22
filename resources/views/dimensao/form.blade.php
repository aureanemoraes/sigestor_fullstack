
<h3>Dimensões Estratégicas</h3>
@php
    if(isset($dimensao)) {
      $route = route('dimensao.update', $dimensao->id);
    } else {
      $route = route('dimensao.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($dimensao))
    @method('PUT')
  @endif
  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($dimensao->nome) ? $dimensao->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
  {{-- {{ dd($dimensao->toArray(), $planos_estrategicos->toArray()) }} --}}
 
  <div class="mb-3">
    <label for="plano_estrategico_id">Plano Estratégico</label>
    <select class="form-select @error('plano_estrategico_id') is-invalid @enderror" id="plano_estrategico_id" name="plano_estrategico_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($planos_estrategicos as $plano_estrategico)
        @if(isset($dimensao) && $plano_estrategico->id == $dimensao->eixo_estrategico->plano_estrategico_id)
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
    <label for="plano_estrategico_id">Eixo Estratégico</label>
    <select class="form-control form-select @error('eixo_estrategico_id') is-invalid @enderror" id="eixo_estrategico_id" name="eixo_estrategico_id" aria-label="Selecione a instituição">
      @if(isset($eixos_estrategicos))
        @foreach($eixos_estrategicos as $eixo_estrategico)
          @if(isset($dimensao) && $eixo_estrategico->id == $dimensao->eixo_estrategico_id)
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
  
  <button type="submit" class="btn btn-primary">Salvar</button>
</form>