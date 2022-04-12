@extends('layouts.app')

@section('css')
    <style>
        .acao-title {
            text-align: center;
        }

        .title {
            vertical-align: middle;
        }

        th.blank {
            border: none;
        }

        .table-ploa {
            font-size: 0.75rem;
        }
   
    </style>
@endsection

@section('content')
    <h3>DISTRIBUIÇÃO MATRIZ PLOA</h3>
    <p>DISTRIBUIÇÃO PLOA {{ Str::upper($instituicao->nome) }} {{ $exercicio->nome }}</p>
    <div class="table-responsive table-responsive-sm">
        <table class="table table-sm table-bordered table-ploa">
            <thead>
                <tr>
                    <th rowspan="2">UASG</th>
                    <th rowspan="2">UNIDADE GESTORA</th>
                    @foreach($acoes as $acao)
                        <th colspan="{{ count($acao->tipos) }}">{{ isset($acao->nome_simplificado) ? $acao->nome_simplificado : $acao->codigo }}</th>
                    @endforeach
                    <th rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    @foreach($acoes as $acao)
                        @foreach($acao->tipos as $key => $tipo)
                            <th>{{ Str::upper($tipo) }}</th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($dados as $i => $dado)
                    @if($i == 'unidades_gestoras')
                        @foreach($dado as $j => $item)
                            <tr>
                                <td>{{ $item['uasg'] }}</td>
                                <td>{{ $item['nome'] }}</td>
                                @foreach($item['acoes'] as $k => $acao)
                                    @if(isset($acao['custeio']))
                                        <td>{{ formatCurrency($acao['custeio']) }}</td>
                                    @endif
                                    @if(isset($acao['investimento']))
                                        <td>{{ formatCurrency($acao['investimento']) }}</td>
                                    @endif
                                @endforeach
                                <td>{{ formatCurrency($item['valor_total']) }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    @foreach($dados_acoes_gestoras as $key => $dado_acao_gestora)
                        @if(isset($dado_acao_gestora['valor_total_custeio']))
                            <th>{{ formatCurrency($dado_acao_gestora['valor_total_custeio']) }}</th>
                        @endif
                        @if(isset($dado_acao_gestora['valor_total_investimento']))
                            <th>{{ formatCurrency($dado_acao_gestora['valor_total_investimento']) }}</th>
                        @endif
                    @endforeach
                    <th>{{ formatCurrency($dados['valor_ploa']) }}</th>
                </tr>
            </tfoot> --}}
        </table>
    </div>
    @foreach($dados as $i => $dado)
        @if($i == 'unidades_gestoras')
            @foreach($dado as $j => $item)
            <p>{{ $item['uasg'] . ' - ' . $item['nome']}}</p>
            <div class="table-responsive table-responsive-sm">
                <table class="table table-sm table-bordered table-ploa">
                    <thead>
                        <tr>
                            <th rowspan="2">UASG</th>
                            <th rowspan="2">UNIDADE ADMINISTRATIVA</th>
                            @foreach($acoes as $acao)
                                <th colspan="{{ count($acao->tipos) }}">{{ isset($acao->nome_simplificado) ? $acao->nome_simplificado : $acao->codigo }}</th>
                            @endforeach
                            <th rowspan="2">TOTAL</th>
                        </tr>
                        <tr>
                            @foreach($acoes as $acao)
                                @foreach($acao->tipos as $key => $tipo)
                                    <th>{{ Str::upper($tipo) }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item['unidades_administrativas'] as $k => $info)
                            <tr>
                                <td>{{ $info['uasg'] }}</td>
                                <td>{{ $info['nome'] }}</td>
                                @foreach($info['acoes'] as $k => $acao)
                                    @if(isset($acao['custeio']))
                                        <td>{{ formatCurrency($acao['custeio']) }}</td>
                                    @endif
                                    @if(isset($acao['investimento']))
                                        <td>{{ formatCurrency($acao['investimento']) }}</td>
                                    @endif
                                @endforeach
                                <td>{{ formatCurrency($info['valor_total']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            @foreach($dados_acoes_gestoras as $key => $dado_acao_gestora)
                                @if(isset($dado_acao_gestora['valor_total_custeio']))
                                    <th>{{ formatCurrency($dado_acao_gestora['valor_total_custeio']) }}</th>
                                @endif
                                @if(isset($dado_acao_gestora['valor_total_investimento']))
                                    <th>{{ formatCurrency($dado_acao_gestora['valor_total_investimento']) }}</th>
                                @endif
                            @endforeach
                            <th>{{ formatCurrency($dados['valor_ploa']) }}</th>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
            @endforeach
        @endif
    @endforeach
@endsection