@extends('layouts.app')

@section('content')
<h3>LOA</h3>
<section>
  <div class="table-responsive">
    <table class="table" id="loas">
      <thead>
        <th>DESCRIÇÃO</th>
        <th>VALOR</th>
        <th>TIPO</th>
        <th>DATA RECEBIMENTO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($loas as $loa)
        <tr>
          <td>{{ $loa->descricao }}</td>
          <td>{{ formatCurrency($loa->valor) }}</td>
          <td>{{ Str::upper($loa->tipo) }}</td>
          <td>{{ formatDate($loa->data_recebimento) }}</td>
          <td>
            <form action="{{ route('loa.destroy', $loa->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('loa.edit', $loa->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#loas').DataTable();
    });
  </script>
@endsection