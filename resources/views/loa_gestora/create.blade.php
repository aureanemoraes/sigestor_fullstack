@extends('layouts.app')

@section('css')
  <style>
    .alert {
      margin-top: 1rem;
      width: 100%;
    }

  </style>
@endsection

@section('content')
  @if(session('error_loa_gestora') != null)
    <section class="alert-container">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-x-circle-fill"></i> </strong>{{ session('error_loa_gestora') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </section>
    @php
      session()->forget(['error_loa_gestora'])
    @endphp
  @endif
  @include('loa.form')
@endsection

@section('js')
  <script>
  </script>
@endsection