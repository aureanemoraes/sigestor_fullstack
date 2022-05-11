@extends('layouts.app')

@section('css')
    <style>
        .cabecalho {
            margin-bottom: 2rem;
        }

        .cabecalho p {
            margin: 0;
            font-size: 0.75rem;
        }
    </style>
@endsection

@section('content')
    <div class="text-center cabecalho">
        <strong>
            <p>MINISTÉRIO DA EDUCAÇÃO</p>
            <p>SECRETARIA DE EDUCAÇÃO PROFISSIONAL E TECNOLÓGICA</p>
            <p>INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DO AMAPÁ</p>
            <p>Qual nome colocar aqui? Unidade Gestora, Unidade Administrativa ou Instituição?</p>
        </strong>
    </div>

    <div class="text-center">
        <p><strong>CERTIDÃO DE CRÉDITO DISPONÍVEL</strong></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th colspan="100%">IDENTIFICAÇÃO DO PROCESSO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>NÚMERO DA CERTIDÃO: {{ $certidao_credito->codigo_certidao }}</td>
                <td>OBJETO: {{ $certidao_credito->credito_planejado->despesa->descricao }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th colspan="100%">IDENTIFICAÇÃO DA UNIDADE E DOS RECURSOS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>UNIDADE</th>
                <th>FONTE</th>
                <th>AÇÃO</th>
                <th>NATUREZA DE DESPESA</th>
                <th>OBSERVAÇÃO</th>
                <th>VALOR ESTIMADO</th>
            </tr>
            <tr>
                <td>
                    {{ $certidao_credito->unidade }}
                </td>
                <td>
                    {{ $certidao_credito->fonte }}
                </td>
                <td>
                    {{ $certidao_credito->acao }}
                </td>
                <td>
                    {{ $certidao_credito->natureza_despesa }}
                </td>
                <td>
                    {{ $certidao_credito->credito_planejado->observacao }}
                </td>
                <td>
                    {{ formatCurrency($certidao_credito->credito_planejado->valor_solicitado) }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-end">VALOR TOTAL</td>
                <td>{{ formatCurrency($certidao_credito->credito_planejado->valor_solicitado) }}</td>
            </tr>
        </tfoot>
    </table>
@endsection