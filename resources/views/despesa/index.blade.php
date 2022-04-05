@extends('layouts.app')

@section('content')
<h3>Despesas Modelos</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('despesa.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
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


{{-- {{ dd($errors->any()) }} --}}

@section('js')
  <script>
    $(document).ready( function () {
      $('#despesas').DataTable();
    });
  </script>
@endsection