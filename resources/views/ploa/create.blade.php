@extends('layouts.app')

@section('content')
  @include('ploa.form')
@endsection

@section('js')
  <script>
    $('#acao_tipo').on('change', () => {
      $('#tipo_acao').html('');

      let acao = JSON.parse($('#acao_tipo').val());
      let tipos_acao = [];
      let html = '<option selected value="">-- selecione --</option>';

      $('#acao_tipo_id').val(acao.id);

      if(acao.investimento)
        tipos_acao.push('investimento');
      if(acao.custeio)
        tipos_acao.push('custeio');

      tipos_acao.map(tipo_acao => {
        let string = tipo_acao[0].toUpperCase() + tipo_acao.substring(1);
        html += `<option value="${tipo_acao}">${string}</option>`;
      });

      $('#tipo_acao').html(html);
      // console.log(acao, tipos_acao);
    });

    $(document).ready(function() {
        $('#exercicio_id').select2();
        $('#programa_id').select2();
        $('#fonte_tipo_id').select2();
        $('#acao_tipo').select2();
    });
  </script>
@endsection