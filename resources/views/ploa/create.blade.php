@extends('layouts.app')

@section('content')
  @include('ploa.form')
@endsection

@section('js')
  <script>
    $(document).ready(function() {
        $('#exercicio_id').select2();
        $('#programa_id').select2();
        $('#fonte_tipo_id').select2();
        $('#acao_tipo_id').select2();
    });
  </script>
@endsection