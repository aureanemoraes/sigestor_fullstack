@php
  use App\Models\PloaGestora;
  use App\Models\Programa;
@endphp
<section>
  <div class="d-flex justify-content-end ">
    <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($total_ploa) }}</p>
  </div>
  @foreach($programas_ploa as $programa)
  @php
    $valores_programa = Programa::valores($programa, 'ploa_gestora', $unidade_selecionada->id, $exercicio_selecionado->id);
  @endphp
  <div class="card">
    <div class="card-body">
      <div class="table-responsive-sm table-loa">
        <table class="table table-sm">
            @if(count($programa->ploas) > 0)
              <tbody>
                <tr>
                  <td colspan="3">Programa: <strong>{{ Str::upper($programa->nome) }}</strong></td>
                  <th>VALOR PLOA</th>
                  <th>DISTRIBUIDO</th>
                  <th>A DISTRIBUIR</th>
                  <th>PLANEJADA</th>
                  <th>A PLANEJAR</th>
                  <th></th>
                </tr>
                <tr>
                  <td colspan="3">Total estimado</td>
                  <th>{{ formatCurrency($valores_programa['valor_total']) }}</th>
                  <th>{{ formatCurrency($valores_programa['valor_distribuido']) }}</th>
                  <th>{{ formatCurrency($valores_programa['valor_a_distribuir']) }}</th>
                  <th>{{ formatCurrency($valores_programa['valor_planejado']) }}</th>
                  <th>{{ formatCurrency($valores_programa['valor_a_planejar']) }}</th>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="9">
                    <table class="table mb-0 table-sm">
                      <thead>
                        <tr>
                          <th>Ação</th>
                          <th>Tipo</th>
                          <th>Fonte</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($ploas_gestoras as $ploa_gestora)
                          @if($ploa_gestora->ploa->programa_id == $programa->id)
                            @php
                              $valores_ploa_gestora = PloaGestora::valores($ploa_gestora);
                            @endphp
                          <tr>
                            <td>{{ $ploa_gestora->ploa->acao_tipo->codigo . ' - ' . $ploa_gestora->ploa->acao_tipo->nome }}</td>
                            <td>{{ ucfirst($ploa_gestora->ploa->tipo_acao) }}</td>
                            <td>{{ $ploa_gestora->ploa->fonte_tipo->codigo }}</td>
                            <td>{{ formatCurrency($ploa_gestora->valor) }}</td>
                            <td>
                              {{ formatCurrency($valores_ploa_gestora['valor_distribuido']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa_gestora['valor_a_distribuir']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa_gestora['valor_planejado']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa_gestora['valor_a_planejar']) }}
                            </td>
                            <td>
                              @if(!isset($tipo))
                                <form action="{{ route('ploa_gestora.destroy', $ploa_gestora->id) }}" method="post" id="form-delete">
                                  @csrf
                                  @method('delete')
                                  <div class="btn-group btn-group-sm float-end" role="group" aria-label="acoes">
                                    <button type="button"  class="btn btn-primary" onClick="edit(
                                      '{{ $ploa_gestora->id }}', 
                                      '{{ $ploa_gestora->ploa->exercicio_id }}', 
                                      '{{ $ploa_gestora->ploa->programa_id }}',
                                      '{{ $ploa_gestora->ploa->fonte_tipo_id }}',
                                      '{{ $ploa_gestora->ploa->acao_tipo_id }}',
                                      '{{ json_encode($ploa_gestora->ploa->acao_tipo) }}',
                                      '{{ $ploa_gestora->ploa->tipo_acao }}',
                                      '{{ $ploa_gestora->ploa->instituicao_id }}',
                                      '{{ $ploa_gestora->valor }}'
                                    )"><i class="bi bi-pen-fill"></i></button>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                                  </div>
                                </form>
                              @endif
                            </td>
                          </tr>
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            @endif
        </table>
      </div>
    </div>
  </div>
  @endforeach

</section>