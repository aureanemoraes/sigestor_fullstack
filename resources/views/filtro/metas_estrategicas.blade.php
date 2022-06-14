<nav class="navbar bg-light filtros">
    <div class="container-fluid">
        <form class="row w-100" role="search">
            <div class="col me-2">
                <select class="form-select form-select-sm" id="plano_estrategico_id" name="plano_estrategico_id" aria-label="EXERCÍCIO">
                    @foreach($planos_estrategicos as $plano_estrategico)
                        <option value="{{ $plano_estrategico->id }}" {{ isset($plano_estrategico_id) && $plano_estrategico_id == $plano_estrategico->id ? 'selected' : '' }}>{{ $plano_estrategico->nome }}</option>
                    @endforeach
                </select>
                <label for="plano_estrategico_id" class="form-text">PLANO ESTRATÉGICO</label>
            </div>

            <div class="col me-2">
                <select class="form-select form-select-sm" id="plano_acao_id" name="plano_acao_id" aria-label="EXERCÍCIO">
                    @foreach($planos_acoes as $plano_acao)
                        <option value="{{ $plano_acao->id }}" {{ isset($plano_acao_id) && $plano_acao_id == $plano_acao->id ? 'selected' : '' }}>{{ $plano_acao->nome }}</option>
                    @endforeach
                </select>
                <label for="plano_acao_id" class="form-text">PLANO DE AÇÃO</label>
            </div>

            <div class="col me-2">
                <select class="form-select form-select-sm" id="eixo_estrategico_id" name="eixo_estrategico_id"aria-label="UNIDADE GESTORA">
                    <option value="" >Selecione...</option>
                    @foreach($eixos_estrategicos as $eixo_estrategico)
                        <option value="{{ $eixo_estrategico->id }}" {{ isset($eixo_estrategico_id) && $eixo_estrategico_id == $eixo_estrategico->id ? 'selected' : '' }}>
                        {{ $eixo_estrategico->nome }}
                        </option>
                    @endforeach
                </select>
                <label for="eixo_estrategico_id" class="form-text">EIXO</label>
            </div>

            {{-- <div class="col me-2">
                <select class="form-select form-select-sm" id="objetivo_id" name="objetivo_id" aria-label="UNIDADE ADMINISTRATIVA">
                <option value="">Selecione...</option>
                @foreach($objetivos as $objetivo)
                    <option value="{{ $objetivo->id }}" {{ isset($objetivo_id) && $objetivo_id == $objetivo->id ? 'selected' : '' }}>
                    {{ $objetivo->nome }}
                    </option>
                @endforeach
                </select>
                <label for="objetivo_id" class="form-text">OBJETIVO</label>
            </div> --}}

            <div class="col-md-1">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    
</nav>