
<h3>Subnaturezas de Despesas</h3>
@php
    if(isset($subnatureza_despesa)) {
      $route = route('subnatureza_despesa.update', $subnatureza_despesa->id);
    } else {
      $route = route('subnatureza_despesa.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($subnatureza_despesa))
    @method('PUT')
  @endif

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ isset($subnatureza_despesa->codigo) ? $subnatureza_despesa->codigo : ''}}" placeholder="Nome...">
    <label for="codigo">Código</label>
    @error('codigo')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($subnatureza_despesa->nome) ? $subnatureza_despesa->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="natureza_despesa_id">Natureza de Despesa</label>
    <select class="form-select @error('natureza_despesa_id') is-invalid @enderror" id="natureza_despesa_id" name="natureza_despesa_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($naturezas_despesas as $natureza_despesa)
        @if(isset($subnatureza_despesa) && $natureza_despesa->id == $subnatureza_despesa->natureza_despesa_id)
          <option selected value="{{ $natureza_despesa->id }}">{{ $natureza_despesa->codigo . ' - ' . $natureza_despesa->nome }}</option>
        @else
          <option value="{{ $natureza_despesa->id }}">{{ $natureza_despesa->codigo . ' - ' . $natureza_despesa->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('natureza_despesa_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
