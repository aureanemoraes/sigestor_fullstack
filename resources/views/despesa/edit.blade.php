
@extends('layouts.app')

@section('content')
  @include('despesa.form', [
    'despesa' => $despesa
  ])
@endsection


@section('js')
  <script>

    function loadConfsDespesa() {
      let despesa = JSON.parse($('#despesa').val());
      if(despesa.fields) {
        for(key in despesa.fields) {
          let field = despesa.fields[key];
          let html = `
          <div class="input-group input-group-sm mb-3 col-4 fields" id="${field}">
            <span class="input-group-text" id="field">${field.nome}</span>
            <input type="number" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[${key}][valor]" value="${field.valor}">
          </div>
          <input type="hidden" name="fields[${key}][nome]" value="${field.nome}">
          `;

          $('#fields-container').append(html);
        }
          // despesa.fields.map( field => {
          //   console.log(field);
          // let html = `
          // <div class="input-group input-group-sm mb-3 col-4 fields" id="${field}">
          //   <span class="input-group-text" id="field">${field.label}</span>
          //   <input type="number" class="form-control" aria-label="Campo" aria-describedby="field" name="fields[${field.slug}][valor]" value="${field.valor}">
          // </div>
          // <input type="hidden" name="fields[${field.slug}][nome]" value="${field.label}">
          // `;

          // $('#fields-container').append(html);
        // });
      }

    }

    function loadConfsNaturezas(natureza_despesa_id) {
      let naturezas_despesas = JSON.parse($('#naturezas_despesas').val());

      let natureza_despesa_selecionada = naturezas_despesas.filter(natureza_despesa => {
        return natureza_despesa.id == natureza_despesa_id;
      })

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
    }

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
      let natureza_despesa_id = $('#natureza_despesa_id').val();

      loadConfsNaturezas(natureza_despesa_id);

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
      loadConfsDespesa();
        $('#plano_acao_id').select2();
        $('#meta_id').select2();
        $('#natureza_despesa_id').select2();
        $('#subnatureza_despesa_id').select2();
    });
  </script>
@endsection
