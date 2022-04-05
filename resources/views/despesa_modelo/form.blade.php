<h3>Despesas Modelos</h3>
@php
    if(isset($despesa_modelo)) {
      $route = route('despesa_modelo.update', $despesa_modelo->id);
    } else {
      $route = route('despesa_modelo.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($despesa_modelo))
    @method('PUT')
  @endif

  <div class="row g-3">
    <div class="mb-3 col-md-6">
      <label for="plano_acao_id">Plano de Ação</label>
      <select class="form-select @error('plano_acao_id') is-invalid @enderror" id="plano_acao_id" name="plano_acao_id" aria-label="Selecione o grupo">
        <option value="" selected>-- selecione --</option>
        @foreach($planos_acoes as $plano_acao)
          <option value="{{ $plano_acao->id }}" {{ isset($despesa_modelo->meta) && $despesa_modelo->meta->plano_acao_id == $plano_acao->id ? 'selected' : '' }}>{{ $plano_acao->nome }}</option>
        @endforeach
      </select>
      @error('plano_acao_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mb-3 col-md-6">
      <label for="meta_id">Meta</label>
      <select class="form-select @error('meta_id') is-invalid @enderror" id="meta_id" name="meta_id" aria-label="Selecione o grupo">
        <option value="" selected>-- selecione --</option>
        @if(isset($metas))
          @foreach($metas as $meta)
            <option value="{{ $meta->id }}" {{ isset($meta) && $despesa_modelo->meta_id == $meta->id ? 'selected' : ''}}>{{ $meta->nome }}</option>
          @endforeach
        @endif
      </select>
      @error('meta_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  <div class="row g-3">
    <div class="mb-3 col-md-6">
      <label for="natureza_despesa_id">Natureza de Despesa</label>
      <select class="form-select @error('natureza_despesa_id') is-invalid @enderror" id="natureza_despesa_id" name="natureza_despesa_id" aria-label="Selecione o grupo">
        <option value="" selected>-- selecione --</option>
        @foreach($naturezas_despesas as $natureza_despesa)
          <option value="{{ $natureza_despesa->id }}" {{ isset($despesa_modelo) && $despesa_modelo->natureza_despesa_id == $natureza_despesa->id ? 'selected' : '' }}>{{ $natureza_despesa->nome }}</option>
        @endforeach
      </select>
      @error('natureza_despesa_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <input type="hidden" id="naturezas_despesas" value="{{ json_encode($naturezas_despesas) }}">

    <input type="hidden" id="despesa_modelo" value="{{ isset($despesa_modelo) ? json_encode($despesa_modelo) : null }}">

    <div class="mb-3 col-md-6">
      <label for="subnatureza_despesa_id">Subnatureza de Despesa</label>
      <select class="form-select @error('subnatureza_despesa_id') is-invalid @enderror" id="subnatureza_despesa_id" name="subnatureza_despesa_id" aria-label="Selecione o grupo" disabled>
        <option value="" selected>-- selecione --</option>
        @if(isset($subnaturezas_despesas))
          @foreach($subnaturezas_despesas as $subnatureza_despesa)
            <option value="{{ $subnatureza_despesa->id }}" {{ isset($subnatureza_despesa) && $despesa_modelo->subnatureza_despesa_id == $subnatureza_despesa->id ? 'selected' : ''}}>{{ $subnatureza_despesa->nome }}</option>
          @endforeach
        @endif
      </select>
      @error('subnatureza_despesa_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  <div class="row g-3">
    <div class="mb-3 col-md-6">
      <label for="centro_custo_id">Centro de Custo</label>
      <select class="form-select @error('centro_custo_id') is-invalid @enderror" id="centro_custo_id" name="centro_custo_id" aria-label="Selecione o grupo">
        <option value="" selected>-- selecione --</option>
        @foreach($centros_custos as $centro_custo)
          <option value="{{ $centro_custo->id }}" {{ isset($despesa_modelo) && $despesa_modelo->centro_custo_id == $centro_custo->id ? 'selected' : '' }}>{{ $centro_custo->nome }}</option>
        @endforeach
      </select>
      @error('centro_custo_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mb-3 col-md-6">
      <span>A despesa é obrigatória para a Instituição?</span>
      <div class="form-check @error('tipo') is-invalid @enderror">
        <input class="form-check-input" type="radio" name="tipo" id="despesa_fixa" value="despesa_fixa">
        <label class="form-check-label" for="despesa_fixa">
          Sim
        </label>
      </div>

      <div class="form-check @error('tipo') is-invalid @enderror">
        <input class="form-check-input" type="radio" name="tipo" id="despesa_variavel" value="despesa_variavel">
        <label class="form-check-label" for="despesa_variavel">
          Não
        </label>
      </div>
      @error('tipo')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  <div class="row g-2">
    <div class="form-floating mb-3 col-md-6">
      <textarea class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" id="descricao" name="descricao">{{ isset($despesa_modelo->descricao) ? $despesa_modelo->descricao : '' }}</textarea>
      <label for="floatingTextarea">Descrição</label>
      @error('descricao')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="form-floating mb-3 col-md-6">
      <input type="number" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ isset($despesa_modelo->valor) ? $despesa_modelo->valor : 0}}" placeholder="Nome...">
      <label for="valor">Valor Unitário</label>
      @error('valor')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  <div class="fields-container" id="fields-container">
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
