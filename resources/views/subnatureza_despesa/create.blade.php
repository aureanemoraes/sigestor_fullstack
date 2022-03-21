@extends('layouts.app')

@section('content')
  @include('subnatureza_despesa.form')
@endsection

@section('js')
  <script>
  $(document).ready(function() {
      $('#natureza_despesa_id').select2();
  });
  </script>
@endsection