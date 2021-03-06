@extends('layouts.app')

@section('content')
<h3>Instituições</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('instituicao.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="instituicoes">
      <thead>
        <th>NOME</th>
        <th>SIGLA</th>
        <th>CNPJ</th>
        <th>UGR</th>
        <th>ENDEREÇO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($instituicoes as $instituicao)
        <tr>
          <td>{{ $instituicao->nome }}</td>
          <td>{{ $instituicao->sigla }}</td>
          <td>{{ cnpj($instituicao->cnpj) }}</td>
          <td>{{ $instituicao->ugr }}</td>
          <td>{{ "$instituicao->logradouro, $instituicao->numero, $instituicao->bairro - $instituicao->complemento" }}</td>
          <td>
            <form action="{{ route('instituicao.destroy', $instituicao->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('instituicao.edit', $instituicao->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#instituicoes').DataTable();
    });
  </script>
@endsection