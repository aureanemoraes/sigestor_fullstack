@if((isset($meta_orcamentaria) && is_null($meta_orcamentaria->natureza_despesa_id)) || !isset($meta_orcamentaria))
  <style>
    .sem-vinculo-container {
      display: block;
    }

    .com-vinculo-container {
      display: none;
    }
  </style>
@else
  <style>
    .sem-vinculo-container {
      display: none;
    }

    .com-vinculo-container {
      display: block;
    }
  </style>
@endif
<style>
  .select2-container{
    width: 100%!important;
  }
</style>

<h3>Metas Orçamentárias</h3>
@php
    if(isset($meta_orcamentaria)) {
      $route = route('meta_orcamentaria.update', $meta_orcamentaria->id);
    } else {
      $route = route('meta_orcamentaria.store');
    }
@endphp
<form action="{{ $route }}" method="POST" id="form">
  @csrf
  @if(isset($meta_orcamentaria))
    @method('PUT')
  @endif

  <div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ isset($meta_orcamentaria->nome) ? $meta_orcamentaria->nome : ''}}" placeholder="Nome...">
    <label for="nome">Nome</label>
    @error('nome')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group mb-3">
    <label for="tipo">Vínculo</label>
    <select class="form-select @error('tipo') is-invalid @enderror" aria-label="Tipo" id="tipo" name="tipo">
      <option value="nao_natureza" selected>Não vincula natureza</option>
      <option value="sim_natureza" {{ isset($meta_orcamentaria) && isset($meta_orcamentaria->natureza_despesa_id) ? 'selected' : '' }}>Vincula natureza</option>
    </select>
    @error('tipo')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
  </div>

  <div class="mb-3">
    <label for="acao_tipo_id">Ação</label>
    <select class="form-control form-select @error('acao_tipo_id') is-invalid @enderror" id="acao_tipo_id" name="acao_tipo_id" aria-label="Selecione a instituição">
      <option selected value="">-- selecione --</option>
      @if(isset($acoes))
        @foreach($acoes as $acao)
          @if(isset($meta_orcamentaria) && $acao->id == $meta_orcamentaria->acao_tipo_id)
            <option selected value="{{ $acao->id }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
          @else
            <option value="{{ $acao->id }}">{{ $acao->codigo . ' - ' . $acao->nome }}</option>
          @endif
        @endforeach
      @endif
    </select>
    @error('acao_tipo_id')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <section class="sem-vinculo-container" id="sem-vinculo-container">

  </section>

  <section class="com-vinculo-container" id="com-vinculo-container">
    <div class="mb-3">
      <label for="natureza_despesa_id">Natureza de Despesa</label>
      <select class="form-select @error('natureza_despesa_id') is-invalid @enderror" id="natureza_despesa_id" name="natureza_despesa_id" aria-label="Selecione o grupo" {{ isset($meta_orcamentaria) && is_null($meta_orcamentaria->natureza_despesa_id) ? 'disabled' : '' }}>
        <option value="" selected>-- selecione --</option>
        @if(isset($naturezas_despesas))
          @foreach($naturezas_despesas as $natureza_despesa)
            <option value="{{ $natureza_despesa->id }}" {{ isset($meta_orcamentaria) && $meta_orcamentaria->natureza_despesa_id == $natureza_despesa->id ? 'selected' : '' }}>{{ $natureza_despesa->nome_completo }}</option>
          @endforeach
        @endif
      </select>
      @error('natureza_despesa_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    @php
     
    @endphp

    <div class="mb-3">
      <label for="fields">Campos</label>
      <select class="form-select @error('fields') is-invalid @enderror" id="field" name="field" aria-label="Selecione o grupo" {{ isset($meta_orcamentaria) && is_null($meta_orcamentaria->field) ? 'disabled' : '' }}>
        @if(count($options) > 0)
          <option value="" selected>-- selecione --</option>
          @foreach($options as $option)
            <option value="{{ $option['id'] }}" {{ isset($meta_orcamentaria) && $meta_orcamentaria->field['slug'] == $option['id'] ? 'selected' : '' }}>{{ $option['text']}}</option>
          @endforeach
        @endif
      </select>
      @error('fields')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </section>

  <button type="submit" class="btn btn-primary">Salvar</button>
</form>
