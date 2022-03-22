@extends('layouts.app')

@section('content')
<h3>Subnaturezas de Despesas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('subnatureza_despesa.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="subnaturezas_despesas">
      <thead>
        <th>CÓDIGO</th>
        <th>NOME</th>
        <th>NATUREZA DE DESPESA</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($subnaturezas_despesas as $subnatureza_despesa)
        <tr>
          <td>{{ $subnatureza_despesa->codigo }}</td>
          <td>{{ $subnatureza_despesa->nome }}</td>
          <td>{{ $subnatureza_despesa->natureza_despesa->codigo . ' - ' . $subnatureza_despesa->natureza_despesa->nome }}</td>
          <td class="action-buttons">
            <form action="{{ route('subnatureza_despesa.destroy', $subnatureza_despesa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('subnatureza_despesa.edit', $subnatureza_despesa->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#subnaturezas_despesas').DataTable();
    });
  </script>
@endsection