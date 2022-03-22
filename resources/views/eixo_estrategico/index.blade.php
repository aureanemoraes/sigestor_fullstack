@extends('layouts.app')

@section('content')
<h3>Eixos Estratégicos</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('eixo_estrategico.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="eixos_estrategicos">
      <thead>
        <th>NOME</th>
        <th>PLANO ESTRATÉGICO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($eixos_estrategicos as $eixo_estrategico)
        <tr>
          <td>{{ $eixo_estrategico->nome }}</td>
          <td>{{ $eixo_estrategico->plano_estrategico->nome }}</td>
          <td>
            <form action="{{ route('eixo_estrategico.destroy', $eixo_estrategico->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('eixo_estrategico.edit', $eixo_estrategico->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#eixos_estrategicos').DataTable();
    });
  </script>
@endsection