<section>
  <div class="d-flex justify-content-end ">
    <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($total_ploa) }}</p>
  </div>
  <div class="table-responsive-sm table-loa">
    <table class="table table-sm">
      @foreach($programas as $programa)
        @if(count($programa->ploas) > 0)
          <tbody>
            <tr>
              <th colspan="3">Programa</th>
              <td>{{ $programa->nome }}</td>
              <td></td>
            </tr>
            <tr>
              <th colspan="3">Total estimado</th>
              <td>{{ formatCurrency($programa->ploas()->sum('valor')) }}</td>
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
                    @foreach($programa->ploas as $ploa)
                    <tr>
                      <td>{{ $ploa->acao_tipo->codigo . ' - ' . $ploa->acao_tipo->nome }}</td>
                      <td>{{ ucfirst($ploa->tipo_acao) }}</td>
                      <td>{{ $ploa->fonte_tipo->codigo }}</td>
                      <td>{{ formatCurrency($ploa->valor) }}</td>
                      <td>
                        <form action="{{ route('ploa.destroy', $ploa->id) }}" method="post" id="form-delete">
                          @csrf
                          @method('delete')
                          <div class="btn-group btn-group-sm float-end" role="group" aria-label="acoes">
                            <button type="button"  class="btn btn-primary" ><i class="bi bi-pen-fill" onClick="edit({{ $ploa }})"></i></button>
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
      @endforeach
    </table>
  </div>
</section>