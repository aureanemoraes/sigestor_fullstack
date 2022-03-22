@extends('layouts.app')

@section('content')
<h3>Planos de Ações</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('plano_acao.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="planos_acoes">
      <thead>
        <th>NOME</th>
        <th>ÍNICIO</th>
        <th>FINAL</th>
        <th>PLANO ESTRATÉGICO</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($planos_acoes as $plano_acao)
        <tr>
          <td>{{ $plano_acao->nome }}</td>
          <td>{{ formatDate($plano_acao->data_inicio) }}</td>
          <td>{{ formatDate($plano_acao->data_fim) }}</td>
          <td>{{ $plano_acao->plano_estrategico->nome }}</td>
          <td>
            <form action="{{ route('plano_acao.destroy', $plano_acao->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('plano_acao.edit', $plano_acao->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#planos_acoes').DataTable();
    });
  </script>
@endsection