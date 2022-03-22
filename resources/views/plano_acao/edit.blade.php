
@extends('layouts.app')

@section('content')
  @include('plano_acao.form', [
    'plano_acao' => $plano_acao
  ])
@endsection

@section('js')
  <script>
  $(document).ready(function() {
      $('#plano_estrategico_id').select2();
  });
  </script>
@endsection
