@extends('layouts.app')

@section('content')
<h3>Agendas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('agenda.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="agendas">
      <thead>
        <th>NOME</th>
        <th>ÍNICIO</th>
        <th>FINAL</th>
        <th>STATUS</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($agendas as $agenda)
        <tr>
          <td>{{ $agenda->nome }}</td>
          <td>{{ formatDate($agenda->data_inicio) }}</td>
          <td>{{ formatDate($agenda->data_fim) }}</td>
          <td>{{ $agenda->status }}</td>
          <td>
            <form action="{{ route('agenda.destroy', $agenda->id) }}" method="post" id="form-delete">
              
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('agenda.eventos', $agenda->id) }}" class="btn btn-primary" ><i class="bi bi-eye-fill"></i> Eventos</a>
                <a type="button" href="{{ route('agenda.edit', $agenda->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#agendas').DataTable();
    });
  </script>
@endsection