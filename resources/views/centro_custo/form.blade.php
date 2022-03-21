
<h3>Centros de Custo</h3>
@php
    if(isset($centro_custo)) {
      $route = route('centro_custo.update', $centro_custo->id);
    } else {
      $route = route('centro_custo.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($centro_custo))
    @method('PUT')
  @endif

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($centro_custo->nome) ? $centro_custo->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>