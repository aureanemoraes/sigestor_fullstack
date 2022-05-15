<div class="d-flex justify-content-end align-items-center">
    <div class="mb-3">
        <label for="unidade_gestora_id">Unidade Gestora</label>
        <select class="form-select @error('unidade_gestora_id') is-invalid @enderror" id="unidade_gestora_id" name="unidade_gestora_id" aria-label="Selecione o grupo">
        <option selected value="">-- selecione --</option>
        @foreach($unidades_gestoras as $unidade_gestora)
            <option value="{{ $unidade_gestora->id }}" {{ isset($unidade_selecionada) && $unidade_gestora->id == $unidade_selecionada->id ? 'selected' : '' }}>
                {{ $unidade_gestora->nome }}
            </option>
        @endforeach
        </select>
        @error('unidade_gestora_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 ms-3">
        @if(isset($unidades_administrativas))
            @include('loa_gestora.filtro-unidade-administrativa')
        @endif
    </div>
</div>