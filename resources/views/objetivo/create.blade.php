@extends('layouts.app')

@section('content')
  @include('objetivo.form')
@endsection

@section('js')
  <script>
    $('#plano_estrategico_id').on('change', () => {
      $('#eixo_estrategico_id').empty().trigger("change");
      $('#eixo_estrategico_id').select2({data: [
        {id: '', text: '-- selecione --'}
      ]});
      let plano_estrategico_id = $('#plano_estrategico_id').val();
      if(plano_estrategico_id) {
        $.ajax({
          method: "GET",
          url: `/api/eixo_estrategico/opcoes/${plano_estrategico_id}`,
        }).done(function(response) {
          $('#eixo_estrategico_id').select2({data: response});
        });
      }
    });

    $('#eixo_estrategico_id').on('change', () => {
      $('#dimensao_id').empty().trigger("change");
      $('#dimensao_id').select2({data: [
        {id: '', text: '-- selecione --'}
      ]});
      let eixo_estrategico_id = $('#eixo_estrategico_id').val();
      if(eixo_estrategico_id) {
        $.ajax({
          method: "GET",
          url: `/api/dimensao/opcoes/${eixo_estrategico_id}`,
        }).done(function(response) {
          $('#dimensao_id').select2({data: response});
        });
      }
    });

    $(document).ready(function() {
        $('#plano_estrategico_id').select2();
        $('#eixo_estrategico_id').select2({data: [
          {id: '', text: '-- selecione --'}
        ]});
        $('#dimensao_id').select2({data: [
          {id: '', text: '-- selecione --'}
        ]});
    });
  </script>
@endsection