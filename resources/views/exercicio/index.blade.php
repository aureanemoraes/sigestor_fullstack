@extends('layouts.app')

@section('content')
<h3>Exercícios</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('exercicio.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="exercicios">
      <thead>
        <th>NOME</th>
        <th>ÍNICIO</th>
        <th>FINAL</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($exercicios as $exercicio)
        <tr>
          <td>{{ $exercicio->nome }}</td>
          <td>{{ formatDate($exercicio->data_inicio) }}</td>
          <td>{{ formatDate($exercicio->data_fim) }}</td>
          <td>
            <form action="{{ route('exercicio.destroy', $exercicio->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('exercicio.edit', $exercicio->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#exercicios').DataTable();
    });
  </script>
@endsection