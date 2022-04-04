@extends('layouts.app')

@section('content')
  @include('subnatureza_despesa.form')
@endsection

@section('js')
  <script>
    function adicionarCampo(fields) {
      fields = JSON.parse(fields);
      let contador = $('.fields').length;

      let html = `
        <div class="input-group input-group-sm mb-3 col-4 fields" id="field-${contador}">
          <input type="text" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[]">
          <span class="input-group-text" id="field"><button type="button" class="btn btn-link btn-sm" onClick="removerCampo('field-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button></span>
        </div>
      `;

      if(contador > 0) contador++;

      $('#fields-container').append(html);
    }

    function removerCampo(id) {
      $(`#${id}`).remove();
    }
    
    $(document).ready(function() {
        $('#natureza_despesa_id').select2();
    });
  </script>
@endsection