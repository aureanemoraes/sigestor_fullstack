@extends('layouts.app')

@section('content')
  @include('meta.form')
@endsection

@section('js')
  <script>
    $('#tipo').on('change', () => {
      let tipo = $('#tipo').val();
      switch (tipo) {
        case 'porcentagem':
          $('#tipo_dado').val('porcentagem');
          break;
        case 'valor':
          $('#tipo_dado').val('moeda');
          break;
        case 'numero':
          $('#tipo_dado').val('numeral');
          break;
        case 'maior_que':
          break;
        case 'menor_que':
          break;
      }
    });

    $(document).ready(function() {
        $('#unidade_gestora_id').select2();
        $('#plano_acao_id').select2();
    });
  </script>
@endsection