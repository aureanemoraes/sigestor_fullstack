@extends('layouts.app')

@section('content')
<h3>Dimensões Estratégicas</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('dimensao.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="dimensoes">
      <thead>
        <th>NOME</th>
        <th>EIXO ESTRATÉGICO</th>
        <th>PLANO ESTRATÉGICO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($dimensoes as $dimensao)
        <tr>
          <td>{{ $dimensao->nome }}</td>
          <td>{{ $dimensao->eixo_estrategico->nome }}</td>
          <td>{{ $dimensao->eixo_estrategico->plano_estrategico->nome }}</td>
          <td>
            <form action="{{ route('dimensao.destroy', $dimensao->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('dimensao.edit', $dimensao->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#dimensoes').DataTable();
    });
  </script>
@endsection