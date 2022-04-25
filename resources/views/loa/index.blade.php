@extends('layouts.app')

@section('css')
  <style>
    .table-loa {
      /* max-width: 60rem; */
    }

    .table {
      table-layout:fixed;
    }

    .collapse {
      width: 100%;
    }

    .select2-container{
      width: 100%!important;
    }

    .card {
      margin-bottom: 1rem;
    }

    .alert {
      margin-top: 1rem;
      width: 100%;
    }

    .float-end {
      margin-right: 1rem;
    }

    .total-matriz {
      padding: 0.5rem;
    }
  </style>
@endsection

@section('content')
    @php
    use App\Models\Ploa;
    use App\Models\Programa;
    @endphp
    <h3>PLOA - {{ $exercicio->nome }}</h3>
    <section class="distribuicao-resumo">
      <div class="table-responsive table-responsive-sm">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>LIMITE PLANEJADO</th>
              <th>LIMITE RECEBIDO</th>
              <th>LIMITE A RECEBER</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ formatCurrency($limite_planejado) }}</td>
              <td>{{ formatCurrency($limite_recebido) }}</td>
              <td>{{ formatCurrency($limite_a_receber) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
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
                      $valores_programa = Programa::valores($programa, 'ploa');
                  @endphp
                  <tbody>
                      <tr>
                          <td colspan="3">Programa: <strong>{{ Str::upper($programa->nome) }}</strong></td>
                          <th>VALOR PLOA</th>
                          <th>TOTAL LIMITE RECEBIDO</th>
                          <th>A RECEBER</th>
                          <th></th>
                      </tr>
                      <tr>
                          <td colspan="3">Total estimado</td>
                          <th>{{ formatCurrency($valores_programa['valor_total']) }}</th>
                          <th>{{ formatCurrency($valores_programa['valor_recebido']) }}</th>
                          <th>{{ formatCurrency($valores_programa['valor_a_receber']) }}</th>
                          <th></th>
                      </tr>
                      <tr>
                      <td colspan="7">
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
                                      <td>R$ 00,00</td>
                                      <td>R$ 00,00</td>
                                      <td>
                                          <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                                              <a type="button" href="{{ route('loa.create', ['ploa' => $ploa->id]) }}" class="btn btn-primary" ><i class="bi bi-plus-circle-fill"></i></a>
                                              <a type="button" href="{{ route('loa.loas', $ploa->id) }}" class="btn btn-primary" ><i class="bi bi-list-nested"></i></a>
                                          </div>
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
@endsection