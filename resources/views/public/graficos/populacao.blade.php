@extends('layouts.public')

@section('css')
      <style>
        .grafico-acoes {
            border: 1px solid gray;
            padding: 1rem;
        }

        .card {
            padding: 1rem;
        }
      </style>
@endsection

@section('header-items')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row" >
            <div class="col grafico-acoes">
                <p>ORÇAMENTO LOA {2018}</p>
                <div class="mb-3" style="background: white;">
                    {!! $barchartjs->render() !!}
                </div>
            </div>
            <div class="col">
                <p>CUSTOS E DESPESAS GERAIS</p>
               <div class="mb-3" style="background: white;">
                    {!! $barchartjs2->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection