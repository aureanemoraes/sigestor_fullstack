@extends('layouts.app')

@section('content')
<h3>Naturezas de Despesas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('natureza_despesa.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="naturezas_despesas">
      <thead>
        <th>CÓDIGO</th>
        <th>NOME</th>
        <th>TIPOS DE DESPESAS</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($naturezas_despesas as $natureza_despesa)
        <tr>
          <td>{{ $natureza_despesa->codigo }}</td>
          <td>{{ $natureza_despesa->nome }}</td>
          <td>
              @if($natureza_despesa->tipo)
              <span class="badge bg-secondary">{{ $natureza_despesa->tipo }}</span>
              @endif
          </td>
          <td class="action-buttons">
            <form action="{{ route('natureza_despesa.fav', $natureza_despesa->id) }}" method="post" id="form-fav">
              @csrf
              @method('patch')
              <button class="btn btn-sm btn-{{ $natureza_despesa->fav ? 'info' : 'secondary' }}" type="submit"><i class="bi bi-star-fill"></i></button>
            </form>
            <form action="{{ route('natureza_despesa.destroy', $natureza_despesa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('natureza_despesa.edit', $natureza_despesa->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#naturezas_despesas').DataTable();
    });
  </script>
@endsection