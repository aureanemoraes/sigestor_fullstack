<div class="d-flex justify-content-between align-items-center">
  <div class="d-flex justify-content-between">
    <div class="mb-3 me-3">
      @php
        $exercico_selecionado_id = isset($exercicio_selecionado) ?  $exercicio_selecionado->id : null;
      @endphp
      {{-- <a href="{{ route('relatorio.ploa', [1, $exercico_selecionado_id]) }}" class="btn btn-sm btn-primary">Relatório</a> --}}
    </div>
  </div>
  <div>
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
</div>