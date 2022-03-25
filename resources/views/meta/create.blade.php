@extends('layouts.app')

@section('content')
  @include('meta.form')
@endsection

@section('js')
  <script>
    $(document).ready(function() {
        $('#unidade_gestora_id').select2();
        $('#plano_acao_id').select2();
    });
  </script>
@endsection