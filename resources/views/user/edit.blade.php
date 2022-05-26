
@extends('layouts.app')

@section('content')
  @include('user.form', [
    'user' => $user
  ])
@endsection

@section('js')
<script>

  $('#perfil').on('change', () => {
      let perfil_selecionado = $('#perfil').val();
      if(perfil_selecionado == 'gestor') {
        $('#unidade_gestora_id').removeAttr('disabled');
        $('#unidade_administrativa_id').attr('disabled', 'disabled');
      } else if (perfil_selecionado == 'administrativo') {
        $('#unidade_gestora_id').removeAttr('disabled');
        $('#unidade_administrativa_id').removeAttr('disabled');
      } else {
        $('#unidade_gestora_id').attr('disabled', 'disabled');
        $('#unidade_administrativa_id').attr('disabled', 'disabled');
      }
  });

  $('#unidade_gestora_id').on('change', () => {
      $('#unidade_administrativa_id').empty().trigger("change");
      $('#unidade_administrativa_id').select2({data: [
        {id: '', text: '-- selecione --'}
      ]});
      let unidade_gestora_id = $('#unidade_gestora_id').val();
      if(unidade_gestora_id) {
        $.ajax({
          method: "GET",
          url: `/api/unidade_administrativa/opcoes/${unidade_gestora_id}`,
        }).done(function(response) {
          $('#unidade_administrativa_id').select2({data: response});
        });
      }
    });

    $(document).ready(function() {
        $('#unidade_administrativa_id').select2();
        $('#unidade_gestora_id').select2();
    });
</script>
@endsection


