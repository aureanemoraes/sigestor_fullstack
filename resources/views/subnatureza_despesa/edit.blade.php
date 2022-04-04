
@extends('layouts.app')

@section('content')
  @include('subnatureza_despesa.form', [
    'subnatureza_despesa' => $subnatureza_despesa
  ])
@endsection

@section('js')
  <script>
    let campos_banco_visualizados = false;

    function adicionarCampo(fields) {
      if(fields) {
        fields = JSON.parse(fields);
        let contador = $('.fields').length;

        if(fields.length > 0 && !campos_banco_visualizados) {
          fields.map(field => {
            let html = `
              <div class="input-group input-group-sm mb-3 col-4 fields" id="field-${contador}">
                <input type="text" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[]" value="${field}">
                <span class="input-group-text" id="field"><button type="button" class="btn btn-link btn-sm" onClick="removerCampo('field-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button></span>
              </div>
            `;

            $('#fields-container').append(html);

            contador++;

            campos_banco_visualizados= true;
          });
        } else {
          let html = `
            <div class="input-group input-group-sm mb-3 col-4 fields" id="field-${contador}">
              <input type="text" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[]">
              <span class="input-group-text" id="field"><button type="button" class="btn btn-link btn-sm" onClick="removerCampo('field-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button></span>
            </div>
          `;

          if(contador > 0) contador++;

          $('#fields-container').append(html);
        }
      }
    
    }

    function removerCampo(id) {
      $(`#${id}`).remove();
    }

    $(function() {
      let campos = $('#campos').val();
      $('#natureza_despesa_id').select2();
      adicionarCampo(campos);
    })
  </script>
@endsection
