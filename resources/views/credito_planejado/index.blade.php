@extends('layouts.app')

@section('content')
@if($tipo == 2)
  <h3>PLOA - {{ $exercicio->nome }}</h3>
  @include('loa.navbar')
@elseif($tipo==1)
  <h3>PLOA - {{ $exercicio->nome }} - UNIDADES GESTORAS</h3>
  <input type="hidden" id="exercicio_id" value="{{ $exercicio->id }}">
  @include('loa_gestora.filtro-unidade-gestora')
  @include('loa_gestora.navbar')
@endif
  <section>
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
                      <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                        <a type="button" href="{{ route('credito_planejado.show', [$credito_planejado->id, 'tipo' => $tipo]) }}" class="btn btn-primary" ><i class="bi bi-eye-fill"></i></a>
                      </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </section>
  
@endsection

@section('js')
  <script>
    $(document).ready( function () {
      $('#creditos_planejados').DataTable();
    });

    $('#unidade_gestora_id').on('change', () => {
        let exercicio_id = $('#exercicio_id').val();
        let unidade_gestora_id = $('#unidade_gestora_id').val();
        if(unidade_gestora_id)
            window.location.href = `/credito_planejado?tipo=1&ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}`;
    });
    $(function() {
        $('#unidade_gestora_id').select2();
    })
  </script>
@endsection