@extends('layouts.app')

@section('content')
    <h3>PLOA - {{ $despesa->ploa_administrativa->ploa_gestora->ploa->exercicio->nome }} - UNIDADES ADMINISTRATIVAS</h3>
    <h6>Solicitações de certidão de crédito</h6>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive table-responsive-sm">
                <table class="table table-sm">
                <thead>
                    <th>NATUREZA DE DESPESA</th>
                    <th>DESPESA</th>
                    <th>FONTE</th>
                    <th>VALOR</th>
                    <th>VALOR DISPONÍVEL</th>
                </thead>
                <tbody>
                    <td>{{ $despesa->natureza_despesa->nome_completo }}</td>
                    <td>{{ $despesa->descricao }}</td>
                    <td>{{ $despesa->ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}</td>
                    <td>{{ formatCurrency($despesa->valor_total) }}</td>
                    <td>{{ formatCurrency($despesa->valor_disponivel) }}</td>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive table-responsive-sm">
        <table class="table table-sm" id="creditos_planejados">
            <thead>
                <tr>
                  <th>NÚMERO DA SOLICITAÇÃO</th>
                  <th>CÓDIGO DO PROCESSO</th>
                  <th>UNIDADE ADMINISTRATIVA</th>
                  <th>STATUS</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($creditos_planejados as $credito_planejado)
                  <tr>
                    <td>{{ $credito_planejado->numero_solicitacao }}</td>
                    <td>{{ $credito_planejado->codigo_processo }}</td>
                    <td>{{ $credito_planejado->despesa->ploa_administrativa->unidade_administrativa->sigla }}</td>
                    <td>
                        <span class="badge {{ $credito_planejado->status_gestora['class'] }}">
                          {{ $credito_planejado->status_gestora['texto'] }}
                        </span>
                        <span class="badge {{ $credito_planejado->status_instituicao['class'] }}">
                          {{ $credito_planejado->status_instituicao['texto'] }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('credito_planejado.destroy', $credito_planejado->id) }}" method="post" id="form-delete">
                            @csrf
                            @method('delete')
                            <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                              <a type="button" href="#" class="btn btn-primary" onClick="modalComentario(
                                '{{$credito_planejado->numero_solicitacao }}',
                                '{{$credito_planejado->codigo_processo }}',
                                '{{$credito_planejado->comentarios }}'
                              )">Comentários</a>
                              @if($credito_planejado->unidade_gestora == 'deferido' && $credito_planejado->instituicao == 'deferido' && isset($credito_planejado->certidao_credito))
                                <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                                  <a type="button" href="{{ route('certidao_credito.show', $credito_planejado->certidao_credito->id) }}" class="btn btn-primary" target="_blank">Ver certidão</a>
                                </div>
                              @else
                                <button disabled type="button" href="#" class="btn btn-primary" >Ver certidão</button>
                              @endif
                              <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                            </div>
                          </form>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('partials.modal')
@endsection

@section('js')
  <script>

    function modalComentario(numero_solicitacao, codigo_processo, comentarios) {
      $('#modal-title').text(`Solicitação certidão de crédito - ${numero_solicitacao}`);
      $('#modal-body').text(`${comentarios}`);
      $('#modal').modal('show');
    }

    $(document).ready( function () {
      $('#creditos_planejados').DataTable();
    });
  </script>
@endsection