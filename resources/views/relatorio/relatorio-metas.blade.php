@extends('layouts.relatorio.main')

@section('css')
    <style>
        table.table th {
            vertical-align: middle;
            text-align: center;
        }

        .verticaltext{
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
        .borderless {
            border: none;
        }

        .bordered {
            border-top: 1px solid gray !important;
        }
        
    </style>
@endsection

@section('content')
    @include('relatorio.filtros', ['relatorio' => 'metas'])
    <p><strong>RELATÓRIO DE METAS - MATRIZ {2019}</strong></p>
    <div class="table-responsive table-responsive-sm">
        <table class="table table-bordered table-sm">
            <thead>
                <tr class="borderless">
                    <th class="borderless"></th>
                    <th class="borderless"></th>
                    <th class="bordered" colspan="2"><span class="verticaltext">META</span></th>
                </tr>
                <tr>
                    <th rowspan="2">UASG</th>
                    <th rowspan="2">UNIDADE ADMINISTRATIVA</th>
                    <th colspan="2">VALORES</th>
                </tr>
                <tr>
                    <th>P</th>
                    <th>A</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection