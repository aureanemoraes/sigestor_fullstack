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

@section('breadcrumb')
  @include('partials.breadcrumb', [
    'data' => 
      [
        ['nome' => 'Agendas', 'rota' => 'agenda.index', 'parametros' => []], 
        ['nome' => 'Meta'] 
      ]
    ]
  )
@endsection

@section('content')
@include('agenda.form-evento')
<h3>Agenda de {{ $agenda->exercicio->nome }}</h3>
  @php
    if($errors->any())
      $error = $errors->first();
    elseif (session('error_evento') != null)
      $error = session('error_evento');
  @endphp
  @if(isset($error))
    <section class="alert-container">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-x-circle-fill"></i> </strong>{{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </section>
    @php
      session()->forget(['error_evento']);
    @endphp
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