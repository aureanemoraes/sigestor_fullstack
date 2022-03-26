<h3>Metas Estratégicas</h3>
@php
    if(isset($meta)) {
      $route = route('meta.update', $meta->id);
    } else {
      $route = route('meta.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($meta))
    @method('PUT')
  @endif

  <div class="row g-3">
    <div class="mb-3 col-md-6">
      <label for="plano_estrategico_id">Plano Estratégico</label>
      <select class="form-select"  id="plano_estrategico_id" aria-label="Selecione o grupo" disabled>
          @if(isset($plano_estrategico))
            <option selected value="">{{ $plano_estrategico }}</option>
          @endif
      </select>
    </div>
  
    <div class="mb-3 col-md-6">
      <label for="eixo_estrategico_id">Eixo Estratégico</label>
      <select class="form-select"  id="eixo_estrategico_id" aria-label="Selecione o grupo" disabled>
          @if(isset($eixo_estrategico))
            <option selected value="">{{ $eixo_estrategico }}</option>
          @endif
      </select>
    </div>
  
    <div class="mb-3 col-md-6">
      <label for="dimensao_id">Dimensão Estratégica</label>
      <select class="form-select"  id="dimensao_id" aria-label="Selecione o grupo" disabled>
          @if(isset($dimensao))
            <option selected value="">{{ $dimensao }}</option>
          @endif
      </select>
    </div>

    <div class="mb-3 col-md-6">
      <label for="objetivo_id">Objetivo Estratégico</label>
      <select class="form-select" id="objetivo_id" name="objetivo_id" aria-label="Selecione o grupo">
          @if(isset($objetivo))
            <option selected value="{{ $objetivo->id }}">{{ $objetivo->nome }}</option>
          @endif
      </select>
    </div>
  </div>

  <div class="mb-3">
    <label for="plano_acao_id">Exercício (Plano de Ação)</label>
    <select class="form-select @error('plano_acao_id') is-invalid @enderror" id="plano_acao_id" name="plano_acao_id" aria-label="Selecione o grupo">
      @foreach($planos_acoes as $plano_acao)
        @if(isset($meta) && $meta->plano_acao_id == $plano_acao->id)
          <option value="{{ $plano_acao->id }}" selected>{{ $plano_acao->nome }}</option>
        @else
          <option value="{{ $plano_acao->id }}">{{ $plano_acao->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('plano_acao_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($meta->nome) ? $meta->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-floating mb-3">
    <textarea class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" id="descricao" name="descricao">{{ isset($meta->descricao) ? $meta->descricao : '' }}</textarea>
    <label for="floatingTextarea">Descrição</label>
    @error('descricao')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="row g-3">
    <div class="form-floating mb-3 col-md-3">
      <select class="form-control form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" aria-label="Selecione a instituição">
        <option selected value="">-- selecione --</option>
        <option value="porcentagem" {{ isset($meta->tipo) && $meta->tipo == 'porcentagem' ? 'selected' : ''  }}>
          Porcentagem
        </option>
        <option value="valor" {{ isset($meta->tipo) && $meta->tipo == 'valor' ? 'selected' : ''  }}>
          Valor
        </option>
        <option value="numero" {{ isset($meta->tipo) && $meta->tipo == 'numero' ? 'selected' : ''  }}>
          Número
        </option>
        <option value="maior_que" {{ isset($meta->tipo) && $meta->tipo == 'maior_que' ? 'selected' : ''  }}>
          Maior que
        </option>
        <option value="menor_que" {{ isset($meta->tipo) && $meta->tipo == 'menor_que' ? 'selected' : ''  }}>
          Menor que
        </option>
      </select>
      <label for="tipo">Tipo</label>
      @error('tipo')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  
    <div class="form-floating mb-3 col-md-3">
      <select class="form-control form-select @error('tipo_dado') is-invalid @enderror" id="tipo_dado" name="tipo_dado" aria-label="Selecione a instituição">
        <option selected value="">-- selecione --</option>
        <option value="numeral" {{ isset($meta->tipo_dado) && $meta->tipo_dado == 'numeral' ? 'selected' : ''  }}>
          Numeral
        </option>
        <option value="porcentagem" {{ isset($meta->tipo_dado) && $meta->tipo_dado == 'porcentagem' ? 'selected' : ''  }}>
          Porcentagem
        </option>
        <option value="moeda" {{ isset($meta->tipo_dado) && $meta->tipo_dado == 'moeda' ? 'selected' : ''  }}>
          Moeda (R$)
        </option>
      </select>
      <label for="tipo_dado" {{ isset($meta->tipo_dado) && $meta->tipo_dado == 'tipo_dado' ? 'selected' : ''  }}>
        Tipo de dado
      </label>
      @error('tipo_dado')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  
    <div class="form-floating mb-3 col-md-3">
      <input type="text" class="form-control @error('valor_inicial') is-invalid @enderror" id="valor_inicial" name="valor_inicial" value="{{ isset($meta->valor_inicial) ? $meta->valor_inicial : ''}}" placeholder="Nome...">
      <label for="valor_inicial">Valor Inicial</label>
      @error('valor_inicial')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  
    <div class="form-floating mb-3 col-md-3">
      <input type="text" class="form-control @error('valor_final') is-invalid @enderror" id="valor_final" name="valor_final" value="{{ isset($meta->valor_final) ? $meta->valor_final : ''}}" placeholder="Nome...">
      <label for="valor_final">Valor Inicial</label>
      @error('valor_final')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>

  <div class="mb-3">
    <label for="unidade_gestora_id">Responsável (Unidades Gestoras)</label>
    <select class="form-select @error('unidade_gestora_id') is-invalid @enderror" id="unidade_gestora_id" name="unidade_gestora_id[]" aria-label="Selecione o grupo"  multiple>
      @foreach($unidades_gestoras as $unidade_gestora)
        @if(isset($meta) && in_array($unidade_gestora->id, $meta->responsaveis()->pluck('unidade_gestora_id')->toArray()))
          <option value="{{ $unidade_gestora->id }}" selected>{{ $unidade_gestora->nome }}</option>
        @else
          <option value="{{ $unidade_gestora->id }}">{{ $unidade_gestora->nome }}</option>
        @endif
      @endforeach
    </select>
    @error('unidade_gestora_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
