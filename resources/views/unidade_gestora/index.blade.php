@extends('layouts.app')

@section('content')
<h3>Unidades Gestoras</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('unidade_gestora.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="unidades_gestoras">
      <thead>
        <th>NOME</th>
        <th>SIGLA</th>
        <th>CNPJ</th>
        <th>UASG</th>
        <th>ENDEREÇO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($unidades_gestoras as $unidade_gestora)
        <tr>
          <td>{{ $unidade_gestora->nome }}</td>
          <td>{{ $unidade_gestora->sigla }}</td>
          <td>{{ $unidade_gestora->cnpj }}</td>
          <td>{{ $unidade_gestora->uasg }}</td>
          <td>{{ "$unidade_gestora->logradouro, $unidade_gestora->numero, $unidade_gestora->bairro - $unidade_gestora->complemento" }}</td>
          <td>
            <form action="{{ route('unidade_gestora.destroy', $unidade_gestora->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('unidade_gestora.edit', $unidade_gestora->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#unidades_gestoras').DataTable();
    });
  </script>
@endsection