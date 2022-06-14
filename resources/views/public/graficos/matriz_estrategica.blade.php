@extends('layouts.public')

@section('css')
      <style>
        .grafico-acoes {
            border: 1px solid gray;
        }

        .card {
            margin-top: 1rem;
            padding: 1rem;
        }

        .navbar {
            margin-top: 2rem;
        }

        .card {
            max-height: 600px;
        }

        .resumo-dados-container {
            margin: 0;
            height: 100%;
        }

        .resumo-dados {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .container {
            font-size: 0.83rem;
        }
      </style>
@endsection

@section('header-items')
@endsection

@section('content')
@include('filtro.metas_estrategicas')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-end flex-column">
            <p>DESEMPENHO MATRIZ ESTRATÉGICA - {{ Str::upper($plano_estrategico->nome) }} - {{ Str::upper($plano_acao->nome) }} - {{ isset($eixo_estrategico) ? Str::upper($eixo_estrategico->nome) : 'TODOS OS EIXOS'}}</p>
        </div>
        <div class="row" >
            <div class="col grafico-acoes">
                <div class="mb-3" style="background: white;">
                    @if(is_null($grafico))
                        <p>Não há dados lançados para este exercício.</p>
                    @else
                        {!! $grafico->render() !!}
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="card resumo-dados-container">
                    <div class="card-body resumo-dados">
                        <div class="row">
                            <div class="col">
                                EIXOS <br>
                                {{ count($data_eixos_estrategicos) }}
                            </div>
                            <div class="col">
                                OBJETIVOS <br>
                                {{ count($data_objetivos) }}
                            </div>
                            <div class="col">
                                METAS <br>
                                {{ count($metas_estrategicas) }}
                            </div>
                        </div>
                        <div >
                            <p>METAS ALCANÇADAS</p>
                            <span>{{ $porcentagem_geral_metas }}%</span>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $porcentagem_geral_metas }}%;" aria-valuenow="{{ $porcentagem_geral_metas }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table actual-table" id="metas">
              <thead>
                <tr>
                  <th>EIXO</th>
                  <th>OBJETIVO</th>
                  <th>META</th>
                  <th>ESPERADO</th>
                  <th>ALCANÇADO</th>
                </tr>
              </thead>
              <tbody>
                @foreach($metas_estrategicas as $meta)
                    <tr>
                        <td>{{ $meta->objetivo->dimensao->eixo_estrategico->nome }}</td>
                        <td>{{ $meta->objetivo->nome }}</td>
                        <td>{{ $meta->nome . ': '. $meta->descricao }}</td>
                        <td>{{ $meta->valor_final }}</td>
                        <td>{{ $meta->valor_atingido }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready( function () {
      $('#metas').DataTable();
    });
  </script>
@endsection