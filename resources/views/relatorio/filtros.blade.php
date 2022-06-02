<nav class="navbar bg-light filtros">
    <div class="container-fluid">
        <form class="row w-100" role="search">
            {{-- <select class="form-control me-2">
            </select> --}}
            <div class="col me-2">
                <select class="form-select form-select-sm" id="tipo_relatorio" name="tipo_relatorio" aria-label="EXERCÍCIO">
                    <option>Selecione...</option>
                    <option value="institucional">INSTITUCIONAL</option>
                    <option value="gestor">GESTOR</option>
                    <option value="administrativo">ADMINISTRATIVO</option>
                </select>
                <label for="tipo_relatorio" class="form-text">EXERCÍCIO</label>
            </div>

            <div class="col me-2">
                <select class="form-select form-select-sm" id="exercicio_id" name="exercicio_id" aria-label="EXERCÍCIO">
                    @foreach($exercicios as $exercicio)
                        <option value="{{ $exercicio->id }}" {{ isset($exercicio_selecionado) && $exercicio_selecionado->id == $exercicio->id ? 'selected' : '' }}>{{ $exercicio->nome }}</option>
                    @endforeach
                </select>
                <label for="exercicio_id" class="form-text">EXERCÍCIO</label>
            </div>

            <div class="col me-2">
                <select class="form-select form-select-sm" id="instituicao_id" name="instituicao_id"aria-label="INSTITUIÇÃO">
                  <option value="1" selected>IFAP</option>
                </select>
                <label for="instituicao_id" class="form-text">INSTITUIÇÃO</label>
            </div>

            
            <div class="col me-2">
                <select class="form-select form-select-sm" id="unidade_gestora_id" name="unidade_gestora_id"aria-label="UNIDADE GESTORA">
                    <option>Selecione...</option>
                    @foreach($unidades_gestoras as $unidade_gestora)
                        <option value="{{ $unidade_gestora->id }}" {{ isset($unidade_selecionada) && $unidade_gestora->id == $unidade_selecionada->id ? 'selected' : '' }}>
                        {{ $unidade_gestora->nome }}
                        </option>
                    @endforeach
                </select>
                <label for="unidade_gestora_id" class="form-text">UNIDADE GESTORA</label>
            </div>

            <div class="col me-2">
                <select class="form-select form-select-sm" id="unidade_administrativa_id" name="unidade_administrativa_id" aria-label="UNIDADE ADMINISTRATIVA">
                  <option>Selecione...</option>
                  @foreach($unidades_administrativas as $unidade_administrativa)
                    <option value="{{ $unidade_administrativa->id }}" {{ isset($unidade_selecionada) && $unidade_administrativa->id == $unidade_selecionada->id ? 'selected' : '' }}>
                    {{ $unidade_administrativa->nome }}
                    </option>
                @endforeach
                </select>
                <label for="unidade_administrativa_id" class="form-text">UNIDADE ADMINISTRATIVA</label>
            </div>

            <div class="col-md-1">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    
</nav>