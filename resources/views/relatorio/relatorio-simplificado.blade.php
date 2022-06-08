@extends('layouts.relatorio.main')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    @include('relatorio.filtros', ['relatorio' => 'simplificado'])

    @php
        switch($tipo_relatorio) {
            case 'institucional':
                $lugar = "INSTITUIÇÃO: $entidade->nome_completo";
                break;
            case 'gestor':
                $lugar = "UNIDADE GESTORA: $entidade->nome_completo";
                break;
            case 'administrativo':
                $lugar = "UNIDADE ADMINISTRATIVA: $entidade->nome_completo";
                break;
        }
    @endphp
    <div class="d-flex align-items-end flex-column">
        <p>PLANEJAMENTO ORÇAMENTÁRIO: EXERCÍCIO {{ $exercicio->nome }} – PLOA</p>
        <p>{{ $lugar }}</p>
    </div>
    <div class="resumos row">
        <div class="col metas-orcamentarias">
            {{-- <div class="table-responvise table-responvise-sm">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td class="col">Nome</td>
                            <td class="col bg-secondary">Valor</td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
        </div>
        <div class="col acoes">
            <div class="table-responsive table-responsive-sm">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>DETALHAMENTO</th>
                            <th>MATRIZ</th>
                            <th>PLANEJADO</th>
                            <th>SALDO A PLANEJAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acoes as $acao)
                            <tr>
                                <th rowspan="2">{{ $acao->codigo }}</th>
                                <td>{{ $acao->custeio ? 'Custeio' : ' - ' }}</td>
                                <td>{{ $acao->valores['custeio']['total_matriz'] ? formatCurrency($acao->valores['custeio']['total_matriz']) : ' - ' }}</td>
                                <td>{{ $acao->valores['custeio']['total_planejado'] ? formatCurrency($acao->valores['custeio']['total_planejado']) : ' - ' }}</td>
                                <td>{{ $acao->valores['custeio']['saldo_a_planejar'] ? formatCurrency($acao->valores['custeio']['saldo_a_planejar']) : ' - ' }}</td>
                            </tr>
                            <tr>
                                <td>{{ $acao->investimento ? 'Investimento' : ' - ' }}</td>
                                <td>{{ $acao->valores['investimento']['total_matriz'] ? formatCurrency($acao->valores['investimento']['total_matriz']) : ' - ' }}</td>
                                <td>{{ $acao->valores['investimento']['total_planejado'] ? formatCurrency($acao->valores['investimento']['total_planejado']) : ' - ' }}</td>
                                <td>{{ $acao->valores['investimento']['saldo_a_planejar'] ? formatCurrency($acao->valores['investimento']['saldo_a_planejar']) : ' - ' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="bg-secondary" colspan="2">TOTAL</th>
                            <td class="bg-secondary">{{ formatCurrency($valores_totais['matriz']) }}</td>
                            <td class="bg-secondary">{{ formatCurrency($valores_totais['planejado']) }}</td>
                            <td class="bg-secondary">{{ formatCurrency($valores_totais['saldo_a_planejar']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="relatorio">
        <div class="row">
            <div class="col text-center">
                RELATÓRIO GERAL SIMPLIFICADO
            </div>
            <div class="col-4">
                <div class="table-responsive table-responsive-sm">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>TOTAL CUSTO FIXO</th>
                                <th>TOTAL CUSTO VARIÁVEL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ formatCurrency($valores_totais['despesas_fixas']) }}</td>
                                <td>{{ formatCurrency($valores_totais['despesas_variaveis']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="acao-container">
            @foreach($acoes as $acao)
                <div class="row">
                    <strong>{{ $acao->nome_completo }}</strong>
                </div>
                @if(count($acao->tipos) > 0)
                    @foreach($acao->tipos as $tipo_acao)
                        {{-- @php
                            $total_custo_fixo_por_tipo_acao       = 0;
                            $total_custo_variavel_por_tipo_acao   = 0;
                            $total_por_tipo_acao                  = 0;
                        @endphp --}}

                        <div class="row bg-secondary">
                            <span class="text-center">{{ Str::upper($tipo_acao) }}</span>
                        </div>
                        <div class="table-responsive table-responsive-sm">
                            <table class="table table-sm acao">
                                <thead>
                                    <tr>
                                        <th width="70%"></th>
                                        <th width="10%">CUSTOS FIXOS</th>
                                        <th width="10%">DESPESAS VARIÁVEIS</th>
                                        <th width="10%">VALOR TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($acao[$tipo_acao]['naturezas_despesas'] as $natureza_despesa)
                                        <tr>
                                            <td>{{ $natureza_despesa->nome_completo }}</td>
                                            <td>{{ formatCurrency($natureza_despesa['custo_fixo']) }}</td>
                                            <td>{{ formatCurrency($natureza_despesa['custo_variavel']) }}</td>
                                            <td>{{ formatCurrency($natureza_despesa['total']) }}</td>
                                        </tr>
                                        
                                        @foreach($natureza_despesa->subnaturezas_despesas as $subnatureza_despesa)
                                            <tr>
                                                <td>
                                                    <span class="subnatureza">{{ $subnatureza_despesa->nome_completo }}</span>
                                                </td>
                                                <td>{{ formatCurrency($subnatureza_despesa['custo_fixo']) }}</td>
                                                <td>{{ formatCurrency($subnatureza_despesa['custo_variavel']) }}</td>
                                                <td>{{ formatCurrency($subnatureza_despesa['total']) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-end">TOTAL {{ Str::upper($tipo_acao) }}</th>
                                        <td>{{ formatCurrency($acao[$tipo_acao]['total_custo_fixo']) }}</td>
                                        <td>{{ formatCurrency($acao[$tipo_acao]['total_custo_variavel']) }}</td>
                                        <td>{{ formatCurrency($acao[$tipo_acao]['total']) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endforeach
                    <div class="table-responsive table-responsive-sm">
                        <table class="table table-sm acao-total">
                            <tbody>
                                <tr>
                                    <th class="text-end" width="70%">TOTAL GERAL</th>
                                    <td>{{ formatCurrency($acao['total_custo_fixo']) }}</td>
                                    <td>{{ formatCurrency($acao['total_custo_variavel']) }}</td>
                                    <td>{{ formatCurrency($acao['total']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection