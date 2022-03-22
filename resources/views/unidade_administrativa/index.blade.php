@extends('layouts.app')

@section('content')
<h3>Unidades Administrativas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('unidade_administrativa.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="unidades_administrativas">
      <thead>
        <th>NOME</th>
        <th>SIGLA</th>
        <th>UASG</th>
        <th>UNIDADE GESTORA</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($unidades_administrativas as $unidade_administrativa)
        <tr>
          <td>{{ $unidade_administrativa->nome }}</td>
          <td>{{ $unidade_administrativa->sigla }}</td>
          <td>{{ $unidade_administrativa->uasg }}</td>
          <td>{{ $unidade_administrativa->unidade_gestora->nome }}</td>
          <td>
            <form action="{{ route('unidade_administrativa.destroy', $unidade_administrativa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('unidade_administrativa.edit', $unidade_administrativa->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#unidades_administrativas').DataTable();
    });
  </script>
@endsection