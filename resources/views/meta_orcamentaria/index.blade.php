@extends('layouts.app')

@section('content')
<h3>Metas Orçamentárias</h3>
<section class="d-flex justify-content-end mb-2">
  <a href="{{ route('meta_orcamentaria.create') }}" type="button" class="btn btn-primary">
    Novo
  </a>
</section>
<section>
  <div class="table-responsive">
    <table class="table" id="metas_orcamentarias">
      <thead>
        <th>NOME</th>
        <th>AÇÃO</th>
        <th>NATUREZA DE DESPESA</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($metas_orcamentarias as $meta_orcamentaria)
        <tr>
          <td>{{ $meta_orcamentaria->nome }}</td>
          <td>{{ isset($meta_orcamentaria->acao_tipo) ?$meta_orcamentaria->acao_tipo->nome_completo  : '-'}}</td>
          <td>
            {{ isset($meta_orcamentaria->natureza_despesa) ? $meta_orcamentaria->natureza_despesa->nome_completo . ': ' .  $meta_orcamentaria->field['label'] : '-'}}
          </td>
          <td class="action-buttons">
            <form action="{{ route('meta_orcamentaria.destroy', $meta_orcamentaria->id) }}" method="post" id="form-delete">
              @csrf
              @method('delete')
              <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                <a type="button" href="{{ route('meta_orcamentaria.edit', $meta_orcamentaria->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
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
      $('#metas_orcamentarias').DataTable();
    });
  </script>
@endsection