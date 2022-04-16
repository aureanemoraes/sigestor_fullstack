@extends('layouts.app')

@section('content')
<h3>Despesas</h3>
<section>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive table-responsive-sm">
        <table class="table table-sm">
          <thead>
            <th>EXERCÍCIO</th>
            <th>PROGRAMA</th>
            <th>AÇÃO</th>
            <th>TIPO</th>
            <th>FONTE</th>
            <th></th>
          </thead>
          <tbody>
            <td>{{ $ploa_administrativa->ploa_gestora->ploa->exercicio->nome }}</td>
            <td>{{ $ploa_administrativa->ploa_gestora->ploa->programa->nome }}</td>
            <td>{{ $ploa_administrativa->ploa_gestora->ploa->acao_tipo->nome_completo }}</td>
            <td>{{ $ploa_administrativa->ploa_gestora->ploa->tipo_acao }}</td>
            <td>{{ $ploa_administrativa->ploa_gestora->ploa->fonte_tipo->codigo }}</td>
            <td>{{ formatCurrency($ploa_administrativa->valor) }}</td>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table" id="despesas">
      <thead>
        <th>Descricao</th>
        <th>Valor</th>
        <th>Valor Total</th>
        <th>Tipo</th>
        <th>Centro de Custo</th>
        <th>Natureza de Despesa</th>
        <th>Subnatureza de Despesa</th>
        <th>Meta</th>
        <th>Campos</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($despesas as $despesa)
        <tr>
          <td>{{ isset($despesa->descricao) ? $despesa->descricao : ''}}</td>
          <td>{{ isset($despesa->valor) ? $despesa->valor : '' }}</td>
          <td>{{ isset($despesa->valor_total) ? $despesa->valor_total : '' }}</td>
          <td>{{ isset($despesa->tipo) ? $despesa->tipo : '' }}</td>
          <td>{{ isset($despesa->centro_custo) ?$despesa->centro_custo->nome : ''}}</td>
          <td>{{ isset($despesa->natureza_despesa) ? $despesa->natureza_despesa->nome : '' }}</td>
          <td>{{ isset($despesa->subnatureza_despesa) ?$despesa->subnatureza_despesa->nome : '' }}</td>
          <td>{{ isset($despesa->meta) ? $despesa->meta->nome : '' }}</td>
          <td>
            @if(isset($despesa->fields))
              @foreach($despesa->fields as $key => $field)
                <span class="badge bg-secondary">{{ $field['nome'] . ': '. $field['valor'] }}</span>
              @endforeach
            @else
              -
            @endif
          </td>
          <td>
            <form action="{{ route('despesa.destroy', $despesa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('despesa.edit', $despesa->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
              </div>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
    $(document).ready( function () {
      $('#despesas').DataTable();
    });
  </script>
@endsection