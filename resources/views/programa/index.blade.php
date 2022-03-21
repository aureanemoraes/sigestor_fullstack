@extends('layouts.app')

@section('content')
<h3>Programas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('programa.create') }}" type="button" class="btn btn-success">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="programas">
      <thead>
        <th>CODIGO</th>
        <th>NOME</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($programas as $programa)
        <tr>
          <td>{{ $programa->codigo }}</td>
          <td>{{ $programa->nome }}</td>
          <td class="action-buttons">
            <form action="{{ route('programa.fav', $programa->id) }}" method="post" id="form-fav">
              @csrf
              @method('patch')
              <button class="btn btn-sm btn-{{ $programa->fav ? 'info' : 'secondary' }}" type="submit"><i class="bi bi-star-fill"></i></button>
            </form>
            <form action="{{ route('programa.destroy', $programa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('programa.edit', $programa->id) }}" class="btn btn-outline-warning" ><i class="bi bi-pen-fill"></i></a>
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash3-fill"></i></button>
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
      $('#programas').DataTable();
    });
  </script>
@endsection