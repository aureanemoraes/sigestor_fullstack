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
        @foreach($loas_gestoras as $loa_gestora)
        <tr>
          <td>{{ $loa_gestora->descricao }}</td>
          <td>{{ formatCurrency($loa_gestora->valor) }}</td>
          <td>{{ Str::upper($loa_gestora->tipo) }}</td>
          <td>{{ formatDate($loa_gestora->data_recebimento) }}</td>
          <td>
            <form action="{{ route('loa_gestora.destroy', $loa_gestora->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('loa_gestora.edit', $loa_gestora->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#loa_gestoras').DataTable();
    });
  </script>
@endsection