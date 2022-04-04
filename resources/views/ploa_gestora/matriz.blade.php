@extends('layouts.app')

@section('content')
  <h3>Matriz - Unidades Gestoras</h3>
  @include('ploa_gestora.filtro-unidade-gestora')
  @if(isset($programas_ploa))
    @include('ploa_gestora.tabela-dados', ['tipo' => 'matriz'])
  @else
  @endif
@endsection

@section('js')
  <script>
    $('#unidade_gestora_id').on('change', () => {
      unidade_gestora_id = $('#unidade_gestora_id').val();
      exercicio_id = $('#exercicio_id').val();

      if(unidade_gestora_id && exercicio_id)
        window.location.href = `/ploa_gestora/matriz/${unidade_gestora_id}/${exercicio_id}`;
    });

    $('#exercicio_id').on('change', () => {
      unidade_gestora_id = $('#unidade_gestora_id').val();
      exercicio_id = $('#exercicio_id').val();
      if(unidade_gestora_id && exercicio_id)
        window.location.href = `/ploa_gestora/matriz/${unidade_gestora_id}/${exercicio_id}`;
    });

    $(document).ready(function() {
        $('#exercicio_id').select2();
        $('#unidade_gestora_id').select2();
    });
  </script>
@endsection