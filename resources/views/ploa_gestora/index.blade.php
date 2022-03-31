@extends('layouts.app')

@if(isset($unidade_selecionada))
  @section('css')
    <style>
      .table-loa {
        /* max-width: 60rem; */
      }

      .table {
        table-layout:fixed;
      }

      .collapse {
        width: 100%;
      }

      .select2-container{
        width: 100%!important;
      }

      .card {
        margin-bottom: 1rem;
      }

      .alert {
        margin-top: 1rem;
        width: 100%;
      }

      .float-end {
        margin-right: 1rem;
      }

      .total-matriz {
        padding: 0.5rem;
      }
    </style>
  @endsection

  @section('content')
    <h3>MATRIZ PLOA - DISTRIBUIÇÃO</h3>

    <div class="d-flex justify-content-end">
      @include('ploa_gestora.filtro-unidade-gestora')
    </div>

    <section class="row">
      @if(session('error_ploa_gestora') != null)
        <section class="alert-container">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-x-circle-fill"></i> </strong>{{ session('error_ploa_gestora') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </section>
        @php
          session()->forget(['error_ploa_gestora'])
        @endphp
      @endif
    </section>

    <section class="row">
      <p>
        <button class="btn btn-primary" data-bs-toggle="collapse" href="#novoCollapse" role="button" aria-expanded="false" aria-controls="novoCollapse" id="novo-button">
          Novo
        </button>
      </p>
      <div class="collapse collpase-form" id="novoCollapse">
        <div class="card card-body">
          @include('ploa_gestora.form')
        </div>
      </div>
    </section>
    {{-- @include('ploa_gestora.tabela-dados') --}}
  @endsection

  @section('js')
    <script>
      function edit(ploa_gestora) {
        $('#exercicio_id').val(ploa_gestora.exercicio_id);
        $('#exercicio_id').select2().trigger('change');

        $('#programa_id').val(ploa_gestora.programa_id);
        $('#programa_id').select2().trigger('change');

        $('#fonte_tipo_id').val(ploa_gestora.fonte_tipo_id);
        $('#fonte_tipo_id').select2().trigger('change');

        $('#acao_tipo_id').val(ploa_gestora.acao_tipo_id);

        $('#acao_tipo').val(JSON.stringify(ploa_gestora.acao_tipo));
        $('#acao_tipo').select2().trigger('change');

        $('#tipo_acao').val(ploa_gestora.tipo_acao);

        $('#instituicao_id').val(ploa_gestora.instituicao_id);

        $('#valor').val(ploa_gestora.valor);

        $('.collpase-form').collapse('show');

        $('#subtitle').removeClass('subtitle-new');

        $('#subtitle').addClass('subtitle-edit');
        
        $('#subtitle').text('Edição');

        $('#novo-button').attr('disabled', true);

        $('#cancel-button').show();

        $('#form').attr('action', `/ploa_gestora/${ploa_gestora.id}`);
        $('#form').append('<input type="hidden" name="_method" value="PUT" id="method">');

        $("html, body").animate({ scrollTop: 0 }, "slow");

      }

      $('#cancel-button').on('click', () => {
        $('#exercicio_id').val(null).trigger('change');

        $('#programa_id').val(null).trigger('change');

        $('#fonte_tipo_id').val(null).trigger('change');

        $('#acao_tipo_id').val(null);

        $('#acao_tipo').val(null).trigger('change');

        $('#tipo_acao').val(null);

        $('#instituicao_id').val(null);

        $('#valor').val(null);
        
        $('#novo-button').removeAttr('disabled');

        $('#subtitle').removeClass('subtitle-edit');

        $('#subtitle').addClass('subtitle-new');

        $('#subtitle').text('Novo');

        $('#cancel-button').hide();

        $('#form').attr('action', `/ploa_gestora`);
        $('#method').remove();

        $('.collpase-form').collapse('hide');

      });

      $('#acao_tipo').on('change', () => {
        $('#tipo_acao').html('');

        let acao_tipo = $('#acao_tipo').val();

        if(acao_tipo) {
          let acao = JSON.parse($('#acao_tipo').val());
          let tipos_acao = [];
          let html = '<option selected value="">-- selecione --</option>';

          if(acao.id) {
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
          }
        }
      });

      $('#unidade_gestora_id').on('change', () => {
        $('#unidade_gestora').val($('#unidade_gestora_id').val());
        window.location.href = `/ploa_gestora/${$('#unidade_gestora_id').val()}`;
      });

      $(document).ready(function() {
          $('#exercicio_id').select2();
          $('#programa_id').select2();
          $('#fonte_tipo_id').select2();
          $('#acao_tipo').select2();
          $('#ploa_gestoras').DataTable( {} );
          $('#unidade_gestora_id').select2();
          $('#unidade_gestora').val($('#unidade_gestora_id').val());
      });
    </script>
  @endsection
@else
  @section('content')
  <h3>MATRIZ PLOA - DISTRIBUIÇÃO</h3>
  <div class="d-flex justify-content-end">
    @include('ploa_gestora.filtro-unidade-gestora')
  </div>
  @endsection

  @section('js')
    <script>
      $('#unidade_gestora_id').select2();

      $('#unidade_gestora_id').on('change', () => {
        window.location.href = `/ploa_gestora/${$('#unidade_gestora_id').val()}`;
      });
    </script>
  @endsection
@endif