@extends('layouts.app')

@section('content')
<h3>Planos Estratégicos</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('plano_estrategico.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="planos_estrategicos">
      <thead>
        <th>NOME</th>
        <th>ÍNICIO</th>
        <th>FINAL</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($planos_estrategicos as $plano_estrategico)
        <tr>
          <td>{{ $plano_estrategico->nome }}</td>
          <td>{{ formatDate($plano_estrategico->data_inicio) }}</td>
          <td>{{ formatDate($plano_estrategico->data_fim) }}</td>
          <td>
            <form action="{{ route('plano_estrategico.destroy', $plano_estrategico->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('plano_estrategico.edit', $plano_estrategico->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#planos_estrategicos').DataTable();
    });
  </script>
@endsection