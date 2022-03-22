@extends('layouts.app')

@section('content')
<h3>Fontes</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('fonte_tipo.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="fontes_tipos">
      <thead>
        <th>CÓDIGO</th>
        <th>NOME</th>
        <th>GRUPO</th>
        <th>ESPECIFICAÇÃO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($fontes_tipos as $fonte_tipo)
        <tr>
          <td>{{ $fonte_tipo->codigo }}</td>
          <td>{{ $fonte_tipo->nome }}</td>
          <td>{{ $fonte_tipo->grupo_fonte->nome }}</td>
          <td>{{ $fonte_tipo->especificacao->nome }}</td>
          <td>
            <form action="{{ route('fonte_tipo.destroy', $fonte_tipo->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('fonte_tipo.edit', $fonte_tipo->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#fontes_tipos').DataTable();
    });
  </script>
@endsection