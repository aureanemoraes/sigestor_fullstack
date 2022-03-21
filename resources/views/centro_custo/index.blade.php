@extends('layouts.app')

@section('content')
<h3>Centros de Custo</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('centro_custo.create') }}" type="button" class="btn btn-success">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="centro_custos">
      <thead>
        <th>NOME</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($centro_custos as $centro_custo)
        <tr>
          <td>{{ $centro_custo->nome }}</td>
          <td class="action-buttons">
            <form action="{{ route('centro_custo.destroy', $centro_custo->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('centro_custo.edit', $centro_custo->id) }}" class="btn btn-outline-warning" ><i class="bi bi-pen-fill"></i></a>
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
      $('#centro_custos').DataTable();
    });
  </script>
@endsection