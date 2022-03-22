@extends('layouts.app')

@section('content')
<h3>Ações</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('acao_tipo.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="acoes_tipos">
      <thead>
        <th>CÓDIGO</th>
        <th>NOME</th>
        <th>NOME SIMPLIFICADO</th>
        <th>TIPOS DE DESPESAS</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($acoes_tipos as $acao_tipo)
        <tr>
          <td>{{ $acao_tipo->codigo }}</td>
          <td>{{ $acao_tipo->nome }}</td>
          <td>{{ $acao_tipo->nome_simplificado }}</td>
          <td>
              @if($acao_tipo->custeio)
              <span class="badge bg-secondary">Custeio</span>
              @endif
              @if($acao_tipo->investimento)
              <span class="badge bg-secondary">Investimento</span>
              @endif
          </td>
          <td class="action-buttons">
            <form action="{{ route('acao_tipo.fav', $acao_tipo->id) }}" method="post" id="form-fav">
              @csrf
              @method('patch')
              <button class="btn btn-sm btn-{{ $acao_tipo->fav ? 'info' : 'secondary' }}" type="submit"><i class="bi bi-star-fill"></i></button>
            </form>
            <form action="{{ route('acao_tipo.destroy', $acao_tipo->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('acao_tipo.edit', $acao_tipo->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#acoes_tipos').DataTable();
    });
  </script>
@endsection