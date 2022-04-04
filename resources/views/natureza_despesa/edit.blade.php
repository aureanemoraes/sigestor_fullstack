
@extends('layouts.app')

@section('content')
  @include('natureza_despesa.form', [
    'natureza_despesa' => $natureza_despesa
  ])
@endsection

@section('js')
  <script>
    function adicionarCampo(campos) {
      let contador = $('.campos').length;

      if(campos) {
        if(campos.length > 0) {
          campos.map(campo => {
            let html = `
              <div class="input-group input-group-sm mb-3 col-4 campos" id="campo-${contador}">
                <input type="text" class="form-control" aria-label="Campo" aria-describedby="campo" name="campos[]">
                <span class="input-group-text" id="campo"><button type="button" class="btn btn-link btn-sm" onClick="removerCampo('campo-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button></span>
              </div>
            `;

            $('#campos-container').append(html);

            contador++;
          });
        } else {
          let html = `
            <div class="input-group input-group-sm mb-3 col-4 campos" id="campo-${contador}">
              <input type="text" class="form-control" aria-label="Campo" aria-describedby="campo" name="campos[]">
              <span class="input-group-text" id="campo"><button type="button" class="btn btn-link btn-sm" onClick="removerCampo('campo-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button></span>
            </div>
          `;

          if(contador > 0) contador++;

          $('#campos-container').append(html);
        }
      }
    
    }

    function removerCampo(id) {
      $(`#${id}`).remove();
    }
  </script>
@endsection
