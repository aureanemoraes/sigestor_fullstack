
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>AÇÃO</th>
                        <th>NATUREZA DE DESPESA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $meta_orcamentaria->nome }}</td>
                        <td>{{ isset($meta_orcamentaria->acao_tipo) ?$meta_orcamentaria->acao_tipo->nome_completo  : '-'}}</td>
                        <td>
                            {{ isset($meta_orcamentaria->natureza_despesa) ? $meta_orcamentaria->natureza_despesa->nome_completo . ': ' .  $meta_orcamentaria->field['label'] : '-'}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form action="{{ route('meta_orcamentaria.update.gestora', $meta_orcamentaria->id) }}" method="POST" id="form">
        @csrf
        @method('PUT')
      
        <div class="form-floating mb-3">
          <input type="number" class="form-control @error('qtd_estimada') is-invalid @enderror" id="qtd_estimada" name="qtd_estimada" value="{{ isset($meta_orcamentaria->qtd_estimada) ? $meta_orcamentaria->qtd_estimada : ''}}" placeholder="Nome...">
          <label for="qtd_estimada">Qtd. estimada</label>
          @error('qtd_estimada')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <input type="hidden" name="meta_orcamentaria_id" value="{{ $meta_orcamentaria->id }}">

        <div class="d-flex justify-content-center">
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
        </div>
      
        <button type="submit" class="btn btn-primary">Salvar</button>
      </form>
@endsection


@section('js')
@endsection
