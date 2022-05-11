@extends('layouts.app')

@section('content')
  <h3>PLOA - {{ $exercicio->nome }} - UNIDADES GESTORAS</h3>
  <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">
  @include('loa_gestora.filtro-unidade-gestora')
  @include('loa_gestora.navbar')

  <div class="table-responsive">
    <table class="table" id="empenhos">
      <thead>
        <th>CÓDIGO DO PROCESSO DE SOLICITAÇÃO</th>
        <th>CÓDIDO DA CERTIDÃO DE CRÉDITO</th>
        <th>VALOR</th>
        <th>UNIDADE ADMINISTRATIVA</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($certidoes_creditos as $certidao_credito)
        <tr>
          <td>{{ $certidao_credito->credito_planejado->codigo_processo }}</td>
          <td>{{ $certidao_credito->codigo_certidao }}</td>
          <td>{{ formatCurrency($certidao_credito->credito_planejado->valor_solicitado) }}</td>
          <td>
            {{  $certidao_credito->unidade }}
          </td>
          <td>
            <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
              @if(!isset($certidao_credito->empenho))
                <a type="button" href="{{ route('empenho.create', ['certidao_credito' => $certidao_credito->id]) }}" class="btn btn-primary" >Empenhar</a>
              @else
              <a type="button" href="{{ route('empenho.show', [$certidao_credito->empenho->id]) }}" class="btn btn-primary" >Ver empenho</a>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@section('js')
  <script>
    $('#unidade_gestora_id').select2();

    $(document).ready( function () {
      $('#empenhos').DataTable();
    });
  </script>
@endsection