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
   
    </style>
@endsection

@section('content')
    <h3>DISTRIBUIÇÃO MATRIZ PLOA</h3>
    <div class="table-responsive table-responsive-sm">
        <p>DISTRIBUIÇÃO PLOA {{ Str::upper($instituicao->nome) }} {{ $exercicio->nome }}</p>
        <div class="row">
            <div class="col">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="title">UASG</th>
                            <th rowspan="2" class="title">UNIDADE GESTORA</th>
                            @foreach($acoes as $acao)
                                @php
                                    if($acao->investimento && $acao->custeio)
                                        $colspan = 2;
                                    else
                                        $colspan = 1;
                                @endphp
                                <th class="acao-title" colspan="{{ $colspan }}">{{ isset($acao->nome_simplificado) ? $acao->nome_simplificado : $acao->codigo }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($acoes as $acao)
                                @if($acao->custeio)
                                    @php
                                        $valor_total_custeio[$acao->id] = 0;
                                    @endphp
                                    <th class="acao-title" width="10%">Custeio</th>
                                @endif
                                @if($acao->investimento)
                                    @php
                                        $valor_total_investimento[$acao->id] = 0;
                                    @endphp
                                    <th class="acao-title" width="10%">Investimento</th>
                                @endif
                                @if(!$acao->investimento && !$acao->custeio)
                                    <th></th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unidades_gestoras as $unidade_gestora)
                            @php
                                $valor_total_unidade_gestora[$unidade_gestora->id] = 0;
                            @endphp
                        <tr>
                            <td>{{ $unidade_gestora->uasg }}</td>
                            <td>{{ $unidade_gestora->nome }}</td>
                            @foreach($acoes as $acao)
                                @php
                                    $valor_custeio = 0;
                                    $valor_investimento = 0;
                                @endphp
                                @foreach($acao->ploas as $ploa)
                                    @if($ploa->tipo_acao == 'custeio')
                                        @foreach($ploa->ploas_gestoras as $ploa_gestora)
                                            @if($ploa_gestora->unidade_gestora_id == $unidade_gestora->id)
                                                @php
                                                    $valor_custeio += $ploa_gestora->valor;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($ploa->tipo_acao == 'investimento')
                                        $investimento = true;
                                        @foreach($ploa->ploas_gestoras as $ploa_gestora)
                                            @if($ploa_gestora->unidade_gestora_id == $unidade_gestora->id)
                                                @php
                                                    $valor_investimento += $ploa_gestora->valor;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if($acao->custeio)
                                    @php
                                        $valor_total_custeio[$acao->id] += $valor_custeio;
                                    @endphp
                                    <td>{{ $valor_custeio > 0 ? formatCurrency($valor_custeio) : '' }} </td>
                                @endif
                                @if($acao->investimento)
                                    @php
                                        $valor_total_investimento[$acao->id] += $valor_investimento;
                                    @endphp
                                    <td>{{ $valor_investimento > 0 ? formatCurrency($valor_investimento) : ''}} </td>
                                @endif
        
                            @endforeach
                        </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                @foreach($acoes as $acao)
                                    @if(isset($valor_total_custeio[$acao->id]))
                                        @php
                                            $valor_total_unidade_gestora[$unidade_gestora->id] += $valor_total_custeio[$acao->id];
                                        @endphp
                                        <td>{{ $valor_total_custeio[$acao->id] > 0 ? formatCurrency($valor_total_custeio[$acao->id]) : ''  }}</td>
                                    @endif
                                    @if(isset($valor_total_investimento[$acao->id]))
                                        @php
                                            $valor_total_unidade_gestora[$unidade_gestora->id] += $valor_total_investimento[$acao->id];
                                        @endphp
                                        <td>{{ $valor_total_investimento[$acao->id] > 0 ? formatCurrency($valor_total_investimento[$acao->id]) : ''  }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
            <div class="col-md-1">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th class="blank">&nbsp</th>
                        </tr>
                        <tr>
                            <th rowspan="2">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unidades_gestoras as $unidade_gestora)
                            <tr>
                                <td>{{ $valor_total_unidade_gestora[$unidade_gestora->id] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @foreach($unidades_gestoras as $unidade_gestora)
            @if(count($unidade_gestora->unidades_administrativas) > 0)
                <p>DISTRIBUIÇÃO PLOA {{ Str::upper($unidade_gestora->nome) }} {{ $exercicio->nome }}</p>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="title">UASG</th>
                            <th rowspan="2" class="title">UNIDADE ADMINISTRATIVA</th>
                            @foreach($acoes as $acao)
                                @php
                                    if($acao->investimento && $acao->custeio)
                                        $colspan = 2;
                                    else
                                        $colspan = 1;
                                @endphp
                                <th class="acao-title" colspan="{{ $colspan }}">{{ isset($acao->nome_simplificado) ? $acao->nome_simplificado : $acao->codigo }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($acoes as $acao)
                                @if($acao->custeio)
                                    <th class="acao-title" width="10%">Custeio</th>
                                @endif
                                @if($acao->investimento)
                                    <th class="acao-title" width="10%">Investimento</th>
                                @endif
                                @if(!$acao->investimento && !$acao->custeio)
                                    <th></th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unidade_gestora->unidades_administrativas as $unidade_administrativa)
                        <tr>
                            <td>{{ $unidade_administrativa->uasg }}</td>
                            <td>{{ $unidade_administrativa->nome }}</td>
                            @foreach($acoes as $acao)
                                @php
                                    $valor_custeio = 0;
                                    $valor_investimento = 0;
                                @endphp
                                @foreach($acao->ploas as $ploa)
                                    @if($ploa->tipo_acao == 'custeio')
                                        @foreach($ploa->ploas_gestoras as $ploa_gestora)
                                            @foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa)
                                                @if($ploa_administrativa->unidade_administrativa_id == $unidade_administrativa->id)
                                                    @php
                                                        $valor_custeio += $ploa_administrativa->valor;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                    @if($ploa->tipo_acao == 'investimento')
                                        @foreach($ploa->ploas_gestoras as $ploa_gestora)
                                            @foreach($ploa_gestora->ploas_administrativas as $ploa_administrativa)
                                                @if($ploa_administrativa->unidade_administrativa_id == $unidade_administrativa->id)
                                                    @php
                                                        $valor_investimento += $ploa_administrativa->valor;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                                @if($acao->custeio)
                                    <td>{{ $valor_custeio > 0 ? formatCurrency($valor_custeio) : '' }} </td>
                                @endif
                                @if($acao->investimento)
                                    <td>{{ $valor_investimento > 0 ? formatCurrency($valor_investimento) : ''}} </td>
                                @endif

                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    </div>
@endsection