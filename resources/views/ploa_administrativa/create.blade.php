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
  @if(session('error_ploa') != null)
    <section class="alert-container">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="bi bi-x-circle-fill"></i> </strong>{{ session('error_ploa') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </section>
    @php
      session()->forget(['error_ploa'])
    @endphp
  @endif
  @include('ploa.form')
@endsection

@section('js')
  <script>
    $('#acao_tipo').on('change', () => {
      $('#tipo_acao').html('');

      let acao = JSON.parse($('#acao_tipo').val());
      let tipos_acao = [];
      let html = '<option selected value="">-- selecione --</option>';

      $('#acao_tipo_id').val(acao.id);

      if(acao.investimento)
        tipos_acao.push('investimento');
      if(acao.custeio)
        tipos_acao.push('custeio');

      tipos_acao.map(tipo_acao => {
        let string = tipo_acao[0].toUpperCase() + tipo_acao.substring(1);
        html += `<option value="${tipo_acao}">${string}</option>`;
      });

      $('#tipo_acao').html(html);
      // console.log(acao, tipos_acao);
    });

    $(document).ready(function() {
        $('#exercicio_id').select2();
        $('#programa_id').select2();
        $('#fonte_tipo_id').select2();
        $('#acao_tipo').select2();
    });
  </script>
@endsection