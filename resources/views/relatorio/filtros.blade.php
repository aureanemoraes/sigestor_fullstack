<nav class="navbar bg-light filtros">
    <div class="container-fluid">
        <form class="row w-100" role="search">
            @if(in_array($relatorio, ['simplificado', 'geral']))
                <div class="col me-2">
                    <select class="form-select form-select-sm" id="exercicio_id" name="exercicio_id" aria-label="EXERCÍCIO">
                        @foreach($exercicios as $exercicio)
                            <option value="{{ $exercicio->id }}" {{ isset($exercicio_id) && $exercicio_id == $exercicio->id ? 'selected' : '' }}>{{ $exercicio->nome }}</option>
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
            @endif

            @if(in_array($relatorio, ['simplificado']))
                <div class="col me-2">
                    <select class="form-select form-select-sm" id="unidade_gestora_id" name="unidade_gestora_id"aria-label="UNIDADE GESTORA">
                        <option value="" >Selecione...</option>
                        @foreach($unidades_gestoras as $unidade_gestora)
                            <option value="{{ $unidade_gestora->id }}" {{ isset($unidade_gestora_id) && $unidade_gestora_id == $unidade_gestora->id ? 'selected' : '' }}>
                            {{ $unidade_gestora->nome }}
                            </option>
                        @endforeach
                    </select>
                    <label for="unidade_gestora_id" class="form-text">UNIDADE GESTORA</label>
                </div>

                <div class="col me-2">
                    <select class="form-select form-select-sm" id="unidade_administrativa_id" name="unidade_administrativa_id" aria-label="UNIDADE ADMINISTRATIVA">
                    <option value="">Selecione...</option>
                    @foreach($unidades_administrativas as $unidade_administrativa)
                        <option value="{{ $unidade_administrativa->id }}" {{ isset($unidade_administrativa_id) && $unidade_administrativa_id == $unidade_administrativa->id ? 'selected' : '' }}>
                        {{ $unidade_administrativa->nome }}
                        </option>
                    @endforeach
                    </select>
                    <label for="unidade_administrativa_id" class="form-text">UNIDADE ADMINISTRATIVA</label>
                </div>
            @endif

            <div class="col-md-1">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    
</nav>