<div class="d-flex justify-content-end">
  <div class="mb-3">
    <label for="exercicio_id">Exercício</label>
    <select class="form-select @error('exercicio_id') is-invalid @enderror" id="exercicio_id" name="exercicio_id" aria-label="Selecione o grupo">
      <option selected value="">-- selecione --</option>
      @foreach($exercicios as $exercicio)
          <option value="{{ $exercicio->id }}" {{ isset($exercicio_selecionado) && $exercicio_selecionado->id == $exercicio->id ? 'selected' : '' }}>{{ $exercicio->nome }}</option>
      @endforeach
    </select>
    @error('exercicio_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>
</div>