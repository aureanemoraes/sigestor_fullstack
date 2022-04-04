<div class="d-flex justify-content-end">
    <div class="mb-3 me-3 w-25">
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
    <div class="mb-3 w-25">
      <label for="unidade_administrativa_id">Unidade Administrativa</label>
      <select class="form-select @error('unidade_administrativa_id') is-invalid @enderror" id="unidade_administrativa_id" name="unidade_administrativa_id" aria-label="Selecione o grupo">
        <option selected value="">-- selecione --</option>
        @foreach($unidades_administrativas as $unidade_administrativa)
            <option value="{{ $unidade_administrativa->id }}" {{ isset($unidade_selecionada) && $unidade_administrativa->id == $unidade_selecionada->id ? 'selected' : '' }}>
              {{ $unidade_administrativa->nome }}
            </option>
        @endforeach
      </select>
      @error('unidade_administrativa_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
</div>
