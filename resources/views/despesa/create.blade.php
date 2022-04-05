@extends('layouts.app')

@section('content')
  @include('despesa.form')
@endsection

@section('js')
  <script>
    $('#despesa_modelo_id').on('change', () => {
      let despesa_modelo_id = $('#despesa_modelo_id').val();
      let despesas_modelos = JSON.parse($('#despesas_modelos').val());
      let despesa_modelo_selecionada = null;

      if(despesas_modelos.length > 0) {
        despesa_modelo_selecionada = despesas_modelos.filter(despesa_modelo => {
          return despesa_modelo.id == despesa_modelo_id;
        });

        if(despesa_modelo_selecionada[0]) {
          $('#valor').val(despesa_modelo_selecionada[0].valor);
          $('#valor').attr('disabled', true);
        } else {
          $('#valor').val(0);
          $('#valor').removeAttr('disabled');
        }
          
      }
    });

    $('#plano_acao_id').on('change', () => {
      $('#meta_id').empty().trigger("change");
      $('#meta_id').select2({data: [
        {id: '', text: '-- selecione --'}
      ]});
      let plano_acao_id = $('#plano_acao_id').val();
      if(plano_acao_id) {
        $.ajax({
          method: "GET",
          url: `/api/meta/opcoes/${plano_acao_id}`,
        }).done(function(response) {
          $('#meta_id').select2({data: response});
        });
      }
    });

    $('#natureza_despesa_id').on('change', () => {
      let naturezas_despesas = JSON.parse($('#naturezas_despesas').val());
      let natureza_despesa_id = $('#natureza_despesa_id').val();

      let natureza_despesa_selecionada = naturezas_despesas.filter(natureza_despesa => {
        return natureza_despesa.id == natureza_despesa_id;
      })

      console.log(natureza_despesa_selecionada);

      if(natureza_despesa_selecionada[0].fields) {
        natureza_despesa_selecionada[0].fields.map( field => {
          console.log(field);
          let html = `
          <div class="input-group input-group-sm mb-3 col-4 fields" id="${field}">
            <span class="input-group-text" id="field">${field.label}</span>
            <input type="number" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[${field.slug}][valor]">
          </div>
          <input type="hidden" name="fields[${field.slug}][nome]" value="${field.label}">
          `;

          $('#fields-container').append(html);
        });
      } else {
        $('#fields-container').empty();
      }

      $('#subnatureza_despesa_id').empty().trigger("change");
      $('#subnatureza_despesa_id').select2({data: [
        {id: '', text: '-- selecione --'}
      ]});
      if(natureza_despesa_id) {
        $.ajax({
          method: "GET",
          url: `/api/subnatureza_despesa/opcoes/${natureza_despesa_id}`,
        }).done(function(response) {
          if(response.length > 0) {
            $('#subnatureza_despesa_id').removeAttr('disabled');
            $('#subnatureza_despesa_id').select2({data: response});
          }
          else
            $('#subnatureza_despesa_id').attr('disabled', true);
        });
      }
    });
    
    $(document).ready(function() {
        $('#plano_acao_id').select2();
        $('#meta_id').select2();
        $('#natureza_despesa_id').select2();
        $('#subnatureza_despesa_id').select2();
        $('#despesa_modelo_id').select2();
    });
  </script>
@endsection