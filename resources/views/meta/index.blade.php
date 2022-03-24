@extends('layouts.app')

@section('content')
<h3>Metas Estratégicas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('meta.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="metas">
      <thead>
        <th>NOME</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($metas as $meta)
        <tr>
          <td>{{ $meta->nome }}</td>
          <td class="action-buttons">
            <form action="{{ route('meta.destroy', $meta->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('meta.edit', $meta->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#metas').DataTable();
    });
  </script>
@endsection