@extends('layouts.relatorio.main')

@section('content')
    <div class="d-flex align-items-end flex-column">
        <p>PLANEJAMENTO ORÇAMENTÁRIO: EXERCÍCIO {2019} – PLOA</p>
        <p>{UNIDADE ADMINISTRATIVA}: <span class="badge bg-secondary">{Campus Macapá}</span></p>
    </div>
    <div class="resumos d-flex justify-content-around">
        <div class="metas-orcamentarias">
            <div class="row">
                <div class="col">Nome</div>
                <div class="col bg-secondary">Valor</div>
            </div>
        </div>
        <div class="acoes">
            <table class="table">
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
                    <tr>
                        <th>AÇÃO</th>
                        <td>TIPO DE DESPESA</td>
                        <td>VALOR MATRIZ</td>
                        <td>VALOR PLANEJADO</td>
                        <td>VALOR SALDO A PLANEJAR</td>
                    </tr>
                    <tr>
                        <th class="bg-secondary">TOTAL</th>
                        <td class="bg-secondary">TIPO DE DESPESA</td>
                        <td class="bg-secondary">VALOR MATRIZ</td>
                        <td class="bg-secondary">VALOR PLANEJADO</td>
                        <td class="bg-secondary">VALOR SALDO A PLANEJAR</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="relatorio">
        <div class="row">
            <div class="col text-center">
                RELATÓRIO GERAL SIMPLIFICADO
            </div>
            <div class="col-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>TOTAL CUSTO FIXO</th>
                            <th>TOTAL CUSTO VARIÁVEL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>R$ 00,00</td>
                            <td>R$ 00,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="acao-container">
            <div class="row">
                <strong>NOME COMPLETO AÇÃO</strong>
            </div>
            <div class="row bg-secondary">
                <span class="text-center">TIPO DE DESPESA DA AÇÃO</span>
            </div>
            <table class="table acao">
                <thead>
                    <tr>
                        <th width="70%"></th>
                        <th width="10%">CUSTOS FIXOS</th>
                        <th width="10%">DESPESAS VARIÁVEIS</th>
                        <th width="10%">VALOR TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NATUREZA DE DESPESA</td>
                        <td>R$ 00,00</td>
                        <td>R$ 00,00</td>
                        <td>R$ 00,00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end">TOTAL TIPO DE DESPESA DA AÇÃO</th>
                        <td>R$ 00,00</td>
                        <td>R$ 00,00</td>
                        <td>R$ 00,00</td>
                    </tr>
                </tfoot>
            </table>
            <table class="table acao-total">
                <tbody>
                    <tr>
                        <th class="text-end" width="70%">TOTAL GERAL</th>
                        <td width="10%">R$ 00,00</td>
                        <td width="10%">R$ 00,00</td>
                        <td width="10%">R$ 00,00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection