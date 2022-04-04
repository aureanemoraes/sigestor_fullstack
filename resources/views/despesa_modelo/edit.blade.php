
@extends('layouts.app')

@section('content')
  @include('meta.form', [
    'meta' => $meta
  ])
@endsection

@section('js')
  <script>
  $(document).ready(function() {
      $('#unidade_gestora_id').select2();
  });
  </script>
@endsection
