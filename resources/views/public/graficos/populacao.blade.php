@extends('layouts.public')

@section('css')
    <style>
        .graficos-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: stretch;
            justify-content: center;
            flex-direction: column;
        }

        .graficos-subcontainer-2 {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: stretch;
            justify-content: center;
            flex-direction: row; 
        }

        .graficos-2 {
            width: 80%;
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: end;
            flex-direction: column;
        }

        .graficos-3 {
            width: 20%;
            height: 20%;
            display: flex;
            justify-content: center;
            align-items: start;
        }
      
    </style>
@endsection

@section('header-items')
@endsection

@section('content')
<div class="row" >
    <div class="col">
        <div class="mb-3" style="background: white;">
            {!! $barchartjs->render() !!}
        </div>
        <div class="" style="background: white;">
            {!! $linechartjs->render() !!}
        </div>
    </div>
    <div class="col" >
        <div class="" style="background: white;">
            <p>{!! $piechartjs->render() !!}</p>
        </div>
    </div>
</div>
    
    
    
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- <script>
    var chart = new Chart('blabla', {
        type: 'bar',
        data: {
        },
        options: {
            maintainAspectRatio: false,
        }
    });
</script> --}}
@endsection