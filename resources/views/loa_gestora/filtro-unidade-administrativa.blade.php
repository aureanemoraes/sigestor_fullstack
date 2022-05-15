<label for="unidade_administrativa_id">Unidade Administrativa</label>
<select class="form-select @error('unidade_administrativa_id') is-invalid @enderror" id="unidade_administrativa_id" name="unidade_gestora_id" aria-label="Selecione o grupo">
<option selected value="">-- selecione --</option>
@foreach($unidades_administrativas as $unidade_administrativa)
    <option value="{{ $unidade_administrativa->id }}" {{ isset($unidade_administrativa_selecionada) && $unidade_administrativa->id == $unidade_administrativa_selecionada->id ? 'selected' : '' }}>
        {{ $unidade_administrativa->nome }}
    </option>
@endforeach
</select>
@error('unidade_administrativa_id')
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror