@extends('layouts.app')

@section('css')
  <style>
    .eventos-container {
      margin-top: 1rem;
    }

    .alert {
      margin-top: 1rem;
      width: 100%;
    }


  </style>
@endsection

@section('content')
@include('agenda.form-evento')
<h3>Agenda de {{ $exercicio->nome }}</h3>
@if(isset($agenda))
  <section>
    <div class="card">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Nome: <strong>{{ $agenda->nome }}</strong></li>
          <li class="list-group-item">Abertura: <strong>{{ formatDate($agenda->data_inicio) }}</strong></li>
          <li class="list-group-item">Fechamento:  <strong>{{ formatDate($agenda->data_fim) }}</strong></li>
          <li class="list-group-item">Status: <strong>{{ $agenda->status }}</strong></li>
        </ul>
      </div>
      <div class="card-footer ">
        <form action="{{ route('agenda.destroy', $agenda->id) }}" method="post" id="form-delete" class="d-flex justify-content-end">
          @csrf
          @method('delete')
          <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
            <a type="button" href="{{ route('agenda.edit', $agenda->id) }}" class="btn btn-primary" ><i class="bi bi-pen-fill"></i></a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
          </div>
        </form>
      </div>
    </div>
  </section>
  @php
    if($errors->any())
      $error = $errors->first();
  @endphp
  @if(isset($error))
  <section class="alert-container">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong><i class="bi bi-x-circle-fill"></i> </strong>{{ $error }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </section>
  @endif
  <section class="eventos-container card">
    <div class="d-flex align-items-center justify-content-between card-header">
        <div class="h-100 w-100 d-flex align-items-center "><h6>Eventos de Planejamento</h6></div>
        @if(date('Y-m-y') <= $agenda->data_fim)
        <a type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formEvento" onClick="formEvento('{{ $agenda->nome }}', {{ $agenda->id }})">
          Novo
        </a>
        @endif
    </div>
      <div class="container card-body">
        <div class="table-responsive">
          <table class="table" id="eventos">
            <thead>
              <th>NOME</th>
              <th>ÍNICIO</th>
              <th>FINAL</th>
              <th>STATUS</th>
              <th></th>
            </thead>
            <tbody>
              @foreach($agenda->eventos as $evento)
              <tr>
                <td>{{ $evento->nome }}</td>
                <td>{{ formatDate($evento->data_inicio) }}</td>
                <td>{{ formatDate($evento->data_fim) }}</td>
                <td>{{ $evento->status }}</td>
                <td>
                  <form action="{{ route('evento.destroy', $evento->id) }}" method="post" id="form-delete">
                    @csrf
                    @method('delete')
                    <div class="btn-group btn-group-sm" role="group" aria-label="acoes">
                      <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                    </div>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
  </div>
@else
<div class="card">
  <div class="card-body">
    <section class="d-flex flex-column align-items-center justify-content-center mb-2">
      <p>Nenhuma agenda cadastrada.</p>
      <a href="{{ route('agenda.create', ['exercicio' => $exercicio->id]) }}" type="button" class="btn btn-primary">
        Nova
      </a>
    </section>
  </div>
</div>
@endif
@endsection


@section('js')
  <script>
    function formEvento(agenda_nome, agenda_id, evento=null) {
      $('#agenda_id').html(`<option value="${agenda_id}" selected>${agenda_nome}</option>`);
    }
    $(document).ready( function () {
      $('#eventos').DataTable();
    });
  </script>
@endsection