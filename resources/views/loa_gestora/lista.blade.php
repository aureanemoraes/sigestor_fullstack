@extends('layouts.app')

@section('css')
    <style>
        td.open {
            background: green;
            color: white;
            font-weight: bold;
        }

        td.close {
            background: red;
            color: white;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<h3>LISTA LOAS - UNIDADES GESTORAS</h3>
<section>
  <div class="table-responsive">
    <table class="table" id="exercicios">
      <thead>
        <th></th>
        <th>VALOR TOTAL</th>
        <th>ÍNICIO</th>
        <th>FINAL</th>
        <th>STATUS</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($exercicios as $exercicio)
        <tr>
            <td>{{ $exercicio->nome }}</td>
            <td>{{ formatCurrency($exercicio->ploas()->sum('valor')) }}</td>
            <td>{{ formatDate($exercicio->data_inicio) }}</td>
            <td>{{ formatDate($exercicio->data_fim) }}</td>
            @php
                if($exercicio->status == 'EM VIGÊNCIA')
                    $classe = 'open';
                else
                    $classe = 'close';
            @endphp
            <td class="{{ $classe }}">
                {{ $exercicio->status }}
            </td>
          <td>
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('loa_gestora.index', ['ploa' => $exercicio->id]) }}" class="btn btn-primary" ><i class="bi bi-search"></i></a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
@endsection


{{-- {{ dd($errors->any()) }} --}}

@section('js')
  <script>
    $(document).ready( function () {
      $('#exercicios').DataTable();
    });
  </script>
@endsection