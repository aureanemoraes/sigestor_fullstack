@extends('layouts.app')

@section('content')
  @include('empenho.form')
@endsection

@section('js')
  <script>
    function adicionarCampo(notas_fiscais) {
      notas_fiscais = JSON.parse(notas_fiscais);
      let contador = $('.notas_fiscais').length;

      let html = `

      <div class="row notas_fiscais" id="field-${contador}">
        <div class="col">
              <div class="mb-3">
                  <label for="data" class="form-label">Data da NE</label>
                  <input type="date" class="form-control" id="data" name="notas_fiscais[${contador}][data]" placeholder="name@example.com">
              </div>
        </div>
        <div class="col">
              <div class="mb-3">
                  <label for="numero" class="form-label">Número da NE</label>
                  <input type="text" class="form-control" id="numero" name="notas_fiscais[${contador}][numero] placeholder="Número da NE...">
              </div>
        </div>
        <div class="col">
              <div class="mb-3">
                  <label for="valor" class="form-label">Valor da NE</label>
                  <input type="number" class="form-control" id="valor" name="notas_fiscais[${contador}][valor] placeholder="1000">
              </div>
        </div>
        <div class="col d-flex justify-center align-itens-center">
          <button type="button" class="btn btn-link btn-sm" onClick="removerCampo('field-${contador}')"><i class="bi bi-x-circle-fill"></i> Remover</button>
        </div>
      </div>
      `;

      if(contador > 0) contador++;

      $('#notas_fiscais-container').append(html);
    }

    function removerCampo(id) {
      $(`#${id}`).remove();
    }

    $(function() {
    })
  </script>
@endsection
