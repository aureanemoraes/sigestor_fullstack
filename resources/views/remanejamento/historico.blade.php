@extends('layouts.app')

@section('content')
<h5>Histórico Remanejamentos - {{ $despesa->descricao }}</h5>
<div class="table-responsive">
    <table class="table" id="remanejamentos">
      <thead>
        <th>Nº OFÍCIO</th>
        <th>DATA</th>
        <th>DESPESA</th>
        <th>ACRÉSCIMO</th>
        <th>REMANEJADO</th>
      </thead>
      <tbody>
        @foreach($remanejamentos_destinatarios as $remanejamento_destinatario)
        <tr>
          <td>{{ $remanejamento_destinatario->remanejamento->numero_oficio }}</td>
          <td>{{ formatDate($remanejamento_destinatario->remanejamento->data) }}</td>
          <td>
            @if($remanejamento_destinatario->despesa_destinatario_id == $despesa_id)
              {{ $remanejamento_destinatario->remanejamento->despesa_remetente->descricao }}
            @elseif($remanejamento_destinatario->remanejamento->despesa_remetente_id == $despesa_id)
              {{ $remanejamento_destinatario->despesa_destinatario->descricao }}
            @endif
          </td>
          <td>
            @if($remanejamento_destinatario->despesa_destinatario_id == $despesa_id)
              <span class="text-success">{{ formatCurrency($remanejamento_destinatario->valor) }}</span>
            @elseif($remanejamento_destinatario->remanejamento->despesa_remetente_id == $despesa_id)
              -
            @endif
          </td>
          <td>
            @if($remanejamento_destinatario->despesa_destinatario_id == $despesa_id)
              - 
            @elseif($remanejamento_destinatario->remanejamento->despesa_remetente_id == $despesa_id)
              <span class="text-danger">{{ formatCurrency($remanejamento_destinatario->valor) }}</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@section('js')
    <script>
        $(document).ready( function () {
        $('#remanejamentos').DataTable();
        });
    </script>
@endsection
