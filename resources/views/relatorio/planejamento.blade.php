@extends('layouts.app')

<style>
    table {
        font-size: 0.75rem;
    }
</style>

@section('content')
    <h3>PLANEJAMENTO ORÇAMENTÁRIO EXERCÍCIO {{ $exercicio->nome }} - PLOA</h3>
    <h6>UNIDADE ADMINISTRATIVA: {{ $unidade_administrativa->sigla }} - {{ $unidade_administrativa->nome }}</h6>
    @foreach($dados as $key => $acoes)
        @foreach($acoes as $i => $acao)
            <p><strong>{{ $acao['nome_completo'] }}</strong></p>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">NATUREZA DA DESPESA DETALHADA</th>
                            <th colspan="5">CUSTO FIXO</th>
                            <th colspan="5">CUSTO VARIÁVEL</th>
                        </tr>
                        <tr>
                            <th colspan="5">ESTIMATIVA DE QUANTIDADE DE VALORES PARA {{ $exercicio->nome }}</th>
                            <th colspan="5">ESTIMATIVA DE QUANTIDADE DE VALORES PARA {{ $exercicio->nome }}</th>
                        </tr>
                    </thead>
                    @if(count($acao['naturezas_despesas']) > 0)
                        <tbody>
                            @foreach($acao['naturezas_despesas'] as $natureza_despesa)
                                <tr>
                                    <td>{{ $natureza_despesa['nome'] }}</td>
                                    @foreach($natureza_despesa['fields'] as $field)
                                        <td>{{ $field['label'] }}</td>
                                    @endforeach
                                    <td>Valor</td>
                                    <td>Valor total</td>

                                    @foreach($natureza_despesa['fields'] as $field)
                                        <td>{{ $field['label'] }}</td>
                                    @endforeach
                                    <td>Valor</td>
                                    <td>Valor total</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <tr>
                            <td>Sem despesas cadastradas.</td>
                        </tr>
                    @endif
                </table>
        @endforeach
    @endforeach
@endsection