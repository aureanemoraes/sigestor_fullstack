@extends('layouts.app')

@section('content')
<h3>Despesas Modelos</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('despesa_modelo.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="despesas_modelos">
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
        @foreach($despesas_modelos as $despesa_modelo)
        <tr>
          <td>{{ isset($despesa_modelo->descricao) ? $despesa_modelo->descricao : ''}}</td>
          <td>{{ isset($despesa_modelo->valor) ? $despesa_modelo->valor : '' }}</td>
          <td>{{ isset($despesa_modelo->valor_total) ? $despesa_modelo->valor_total : '' }}</td>
          <td>{{ isset($despesa_modelo->tipo) ? $despesa_modelo->tipo : '' }}</td>
          <td>{{ isset($despesa_modelo->centro_custo) ?$despesa_modelo->centro_custo->nome : ''}}</td>
          <td>{{ isset($despesa_modelo->natureza_despesa) ? $despesa_modelo->natureza_despesa->nome : '' }}</td>
          <td>{{ isset($despesa_modelo->subnatureza_despesa) ?$despesa_modelo->subnatureza_despesa->nome : '' }}</td>
          <td>{{ isset($despesa_modelo->meta) ? $despesa_modelo->meta->nome : '' }}</td>
          <td>
            @if(isset($despesa_modelo->fields))
              @foreach($despesa_modelo->fields as $key => $field)
                <span class="badge bg-secondary">{{ $field['nome'] . ': '. $field['valor'] }}</span>
              @endforeach
            @else
              -
            @endif
          </td>
          <td>
            <form action="{{ route('despesa_modelo.destroy', $despesa_modelo->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('despesa_modelo.edit', $despesa_modelo->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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


{{-- {{ dd($errors->any()) }} --}}

@section('js')
  <script>
    $(document).ready( function () {
      $('#despesas_modelos').DataTable();
    });
  </script>
@endsection