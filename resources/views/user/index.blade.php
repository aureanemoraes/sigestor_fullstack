@extends('layouts.app')

@section('content')
<h3>Usuários</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('user.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="users">
      <thead>
        <th>NOME</th>
        <th>MATRÍCULA</th>
        <th>CPF</th>
        <th>PERFIL</th>
        <th>ATIVO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->nome }}</td>
          <td>{{ $user->matricula }}</td>
          <td>{{ $user->cpf }}</td>
          <td>{{ $user->perfil }}</td>
          <td>{{ $user->ativo }}</td>
          <td>
            <form action="{{ route('user.destroy', $user->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('user.edit', $user->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#users').DataTable();
    });
  </script>
@endsection