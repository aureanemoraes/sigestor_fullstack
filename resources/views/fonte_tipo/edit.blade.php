
@extends('layouts.app')

@section('content')
  @include('fonte_tipo.form', [
    'fonte_tipo' => $fonte_tipo
  ])
@endsection

@section('js')
  <script>
  $(document).ready(function() {
      $('#grupo_fonte_id').select2();
      $('#especificacao_id').select2();
  });
  </script>
@endsection
