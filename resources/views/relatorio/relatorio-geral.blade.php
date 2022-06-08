@extends('layouts.relatorio.main')

@section('css')
    <style>
        .container {
            font-size: 0.83rem;
        }

        .subnatureza {
            padding-left: 1rem;
        }
    </style>
@endsection

@section('content')
    @include('relatorio.filtros', ['relatorio' => 'geral'])
    
    <p class="text-center"><strong>RELATÓRIO GERAL COM DISTRIBUIÇÃO - MATRIZ {{ $exercicio->nome }}</strong></p>
    <div class="resumos row">
        <div class="col">
            <table class="table table-secondary table-sm">
                <thead>
                    <tr>
                        <th>VALOR TOTAL - PLOA {{ $exercicio->nome }}</th>
                        <th>VALOR TOTAL PLANEJADO - PLOA {{ $exercicio->nome }}</th>
                        <th>SALDO A PLANEJAR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $valores_gerais['valor_total'] > 0 ? formatCurrency($valores_gerais['valor_total']) : '-' }}</td>
                        <td>{{ $valores_gerais['valor_planejado'] > 0 ? formatCurrency($valores_gerais['valor_planejado']) : '-' }}</td>
                        <td>{{ $valores_gerais['saldo_a_planejar'] > 0 ? formatCurrency($valores_gerais['saldo_a_planejar']) : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col">
            <table class="table table-primary table-sm">
                <thead>
                    <tr>
                        <th>TOTAL CUSTO FIXO</th>
                        <th>TOTAL CUSTO VARIÁVEL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $valores_gerais['valor_total_custo_fixo'] > 0 ? formatCurrency($valores_gerais['valor_total_custo_fixo']) : '-' }}</td>
                        <td>{{ $valores_gerais['valor_total_custo_variavel'] > 0 ? formatCurrency($valores_gerais['valor_total_custo_variavel']) : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        @foreach($acoes as $acao)
            <strong>{{ $acao->nome_completo }}</strong>
            <div class="table-responsive table-responsive-sm">
                <table class="table table-sm acao">
                    <thead>
                        <tr>
                            <th width="70%"></th>
                            @foreach($acao->unidades_gestoras as $unidade_gestora => $dados)
                                @if(count($dados['naturezas_despesas']) > 0)
                                    <th width="10%">{{ $unidade_gestora }}</th>
                                @endif
                            @endforeach
                            <th width="10%">VALOR TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($acao['naturezas_despesas'] as $natureza_despesa_id => $natureza_despesa_geral)
                                <tr>
                                    <td>{{ $natureza_despesa_geral['nome_completo'] }}</td>
                                    @foreach($acao->unidades_gestoras as $unidade_gestora => $dados)
                                        @if(count($dados['naturezas_despesas']) > 0)
                                            @php
                                                $possui_valor = false;
                                            @endphp

                                            @foreach($dados['naturezas_despesas'] as $key => $natureza_despesa)
                                                @if($natureza_despesa->id == $natureza_despesa_id)
                                                    <td>{{ $natureza_despesa['valor_total'] > 0 ? formatCurrency($natureza_despesa['valor_total']) : '-' }}</td>
                                                    @php
                                                        $possui_valor = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if(!$possui_valor)
                                                <td></td>
                                            @endif
                                        @endif
                                    @endforeach
                                    <td>{{ formatCurrency($natureza_despesa_geral['valor_total']) }}</td>
                                </tr>
                                @if(count($natureza_despesa_geral['subnaturezas_despesas']) > 0)
                                    @foreach($natureza_despesa_geral['subnaturezas_despesas'] as $subnatureza_despesa_id => $subnatureza_despesa)
                                        <tr>
                                            <td><span class="subnatureza">{{ $subnatureza_despesa['nome_completo'] }}</span></td>
                                            @foreach($acao->unidades_gestoras as $unidade_gestora => $dados)
                                            @if(count($dados['naturezas_despesas']) > 0)
                                                    @php
                                                        $possui_valor = false;
                                                    @endphp

                                                    @foreach($dados['naturezas_despesas'] as $key => $natureza_despesa)
                                                        @if(count($natureza_despesa->subnaturezas_despesas) > 0)
                                                            @foreach($natureza_despesa->subnaturezas_despesas as $subnatureza)
                                                                @if($subnatureza->id == $subnatureza_despesa_id)
                                                                    <td>{{ $subnatureza['valor_total'] > 0 ? formatCurrency($subnatureza['valor_total']) : '-' }}</td>
                                                                    @php
                                                                        $possui_valor = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if(!$possui_valor)
                                                        <td></td>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td>{{ formatCurrency($subnatureza_despesa['valor_total']) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-end">TOTAL AÇÃO</th>
                            @foreach($acao->unidades_gestoras as $unidade_gestora => $dados)
                                @if(count($dados['naturezas_despesas']) > 0)
                                <td>{{ formatCurrency($dados['valor_total']) }}</td>
                                @endif
                            @endforeach
                            <td>{{ formatCurrency($acao['valor_total'])}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
    </div>
@endsection