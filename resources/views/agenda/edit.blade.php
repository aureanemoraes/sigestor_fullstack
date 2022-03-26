
@extends('layouts.app')

@section('content')
  @include('agenda.form', [
    'agenda' => $agenda
  ])
@endsection

