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
              <tbody>
                <tr>
                  <td colspan="5">Programa: <strong>{{ Str::upper($programa->nome) }}</strong></td>
                </tr>
                <tr>
                  <td colspan="3">Total estimado</td>
                  <th>{{ formatCurrency($programa->valor_total) }}</th>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <table class="table mb-0 table-sm">
                      <thead>
                        <tr>
                          <th>Ação</th>
                          <th>Tipo</th>
                          <th>Fonte</th>
                          <th>Valor</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($ploas_administrativas as $ploa_administrativa)
                          @if($ploa_administrativa->ploa_gestora->ploa->programa_id == $programa->id)
                          <tr>
                            <td>{{ $ploa_administrativa->ploa_gestora->ploa->acao_tipo->codigo . ' - ' . $ploa_administrativa->ploa_gestora->ploa->acao_tipo->nome }}</td>
                            <td>{{ ucfirst($ploa_administrativa->ploa_gestora->ploa->tipo_acao) }}</td>
                            <td>{{ $ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}</td>
                            <td>{{ formatCurrency($ploa_administrativa->valor) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm float-end" role="group" aria-label="acoes">
                                  <a href="{{ route('despesa.create', ['ploa_administrativa' => $ploa_administrativa->id]) }}" type="button"  class="btn btn-primary"><i class="bi bi-list-ul"></i> Planejar</a>
                                </div>
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