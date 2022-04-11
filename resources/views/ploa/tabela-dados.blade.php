@php
  use App\Models\Ploa;
  use App\Models\Programa;
@endphp
<section>
  <div class="d-flex justify-content-end ">
    <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($total_ploa) }}</p>
  </div>
  @foreach($programas_ploa as $programa)
  <div class="card">
    <div class="card-body">
      <div class="table-responsive-sm table-loa">
        <table class="table table-sm">
            @if(count($programa->ploas) > 0)
              @php
                $valores_programa = Programa::valores($programa);
              @endphp
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
                  <th></td>
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
                        @foreach($programa->ploas as $ploa)
                          @php
                            $valores_ploa = Ploa::valores($ploa);
                          @endphp
                          <tr>
                            <td>{{ $ploa->acao_tipo->codigo . ' - ' . $ploa->acao_tipo->nome }}</td>
                            <td>{{ ucfirst($ploa->tipo_acao) }}</td>
                            <td>{{ $ploa->fonte_tipo->codigo }}</td>
                            <td>{{ formatCurrency($ploa->valor) }}</td>
                            <td>
                              {{ formatCurrency($valores_ploa['valor_distribuido']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa['valor_a_distribuir']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa['valor_planejado']) }}
                            </td>
                            <td>
                              {{ formatCurrency($valores_ploa['valor_a_planejar']) }}
                            </td>
                            <td>
                              <form action="{{ route('ploa.destroy', $ploa->id) }}" method="post" id="form-delete">
                                @csrf
                                @method('delete')
                                <div class="btn-group btn-group-sm float-end" role="group" aria-label="acoes">
                                  <button type="button"  class="btn btn-primary"  
                                    onClick="edit(
                                      '{{ $ploa->id }}', 
                                      '{{ $ploa->exercicio_id }}', 
                                      '{{ $ploa->programa_id }}',
                                      '{{ $ploa->fonte_tipo_id }}',
                                      '{{ $ploa->acao_tipo_id }}',
                                      '{{ json_encode($ploa->acao_tipo) }}',
                                      '{{ $ploa->tipo_acao }}',
                                      '{{ $ploa->instituicao_id }}',
                                      '{{ $ploa->valor }}'
                                    )"
                                  ><i class="bi bi-pen-fill"></i></button>
                                  <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                              </form>
                            </td>
                          </tr>
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