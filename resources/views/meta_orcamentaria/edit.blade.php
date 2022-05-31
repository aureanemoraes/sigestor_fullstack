
@extends('layouts.app')

@section('content')
  @include('meta_orcamentaria.form', [
    'meta_orcamentaria' => $meta_orcamentaria
  ])
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

      $('#field-container').append(html);
    }

    function removerCampo(id) {
      $(`#${id}`).remove();
    }

    $('#tipo').on('change', () => {
      let tipo_selecionado = $('#tipo').val();

      if(tipo_selecionado == 'sim_acao') {
        $('#sem-vinculo-container').hide();
        $('#qtd_estimada').attr('disabled', 'disabled');
        $('#qtd_alcancada').attr('disabled', 'disabled');
        $('#acao_tipo_id').removeAttr('disabled');
        $('#natureza_despesa_id').removeAttr('disabled');
        $('#com-vinculo-container').show();
      } else {
        $('#com-vinculo-container').hide();
        $('#qtd_estimada').removeAttr('disabled');
        $('#qtd_alcancada').removeAttr('disabled');
        $('#sem-vinculo-container').show();
      }
    });

    $('#natureza_despesa_id').on('change', () => {
      let natureza_despesa_id = $('#natureza_despesa_id').val();

      $.ajax({
          method: "GET",
          url: `/api/natureza_despesa/fields/${natureza_despesa_id}`,
        }).done(function(response) {
          $('#field').empty().trigger("change");
          $('#field').select2({data: response});

        });
    });

    $(function() {
      $('#natureza_despesa_id').select2({});
      $('#acao_tipo_id').select2({});
      $('#field').select2({});
    })
  </script>
@endsection
