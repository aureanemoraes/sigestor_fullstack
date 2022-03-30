@extends('layouts.app')

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
<h3>
    PLOA - Matriz
</h3>

<section class="row">
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
</section>

<section class="row">
  {{-- <div class="d-flex justify-content-end mb-2 col">
    <a href="{{ route('ploa.create') }}" type="button" class="btn btn-primary">
      Novo
    </a>
  </div> --}}
  <p>
    <button class="btn btn-primary" data-bs-toggle="collapse" href="#novoCollapse" role="button" aria-expanded="false" aria-controls="novoCollapse" id="novo-button">
      Novo
    </button>
  </p>
  <div class="collapse collpase-form" id="novoCollapse">
    <div class="card card-body">
      @include('ploa.form')
    </div>
  </div>
</section>
<section>
  <div class="d-flex justify-content-end ">
    <p class="btn-primary total-matriz">VALOR TOTAL: {{ formatCurrency($total_ploa) }}</p>
  </div>
  <div class="table-responsive-sm table-loa">
    <table class="table table-secondary table-sm">
      @foreach($programas as $programa)
        @if(count($programa->ploas) > 0)
          <tbody>
            <tr>
              <th colspan="3">Programa</th>
              <td>{{ $programa->nome }}</td>
              <td></td>
            </tr>
            <tr>
              <th colspan="3">Total estimado</th>
              <td>{{ formatCurrency($programa->ploas()->sum('valor')) }}</td>
              <td></td>
            </tr>
            <tr>
              <td colspan="5">
                <table class="table table-light mb-0 table-sm">
                  <thead>
                    <tr>
                      <th>Ação</th>
                      <th>Tipo</th>
                      <th>Fonte</th>
                      <th>Valor</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($programa->ploas as $ploa)
                    <tr>
                      <td>{{ $ploa->acao_tipo->codigo . ' - ' . $ploa->acao_tipo->nome }}</td>
                      <td>{{ ucfirst($ploa->tipo_acao) }}</td>
                      <td>{{ $ploa->fonte_tipo->codigo }}</td>
                      <td>{{ formatCurrency($ploa->valor) }}</td>
                      <td>
                        <form action="{{ route('ploa.destroy', $ploa->id) }}" method="post" id="form-delete">
                          @csrf
                          @method('delete')
                          <div class="btn-group btn-group-sm float-end" role="group" aria-label="acoes">
                            <button type="button"  class="btn btn-primary" ><i class="bi bi-pen-fill" onClick="edit({{ $ploa }})"></i></button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-trash3-fill"></i></button>
                          </div>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        @endif
      @endforeach
    </table>
  </div>
</section>
@endsection

@section('js')
  <script>
    function edit(ploa) {
      $('#exercicio_id').val(ploa.exercicio_id);
      $('#exercicio_id').select2().trigger('change');

      $('#programa_id').val(ploa.programa_id);
      $('#programa_id').select2().trigger('change');

      $('#fonte_tipo_id').val(ploa.fonte_tipo_id);
      $('#fonte_tipo_id').select2().trigger('change');

      $('#acao_tipo_id').val(ploa.acao_tipo_id);

      $('#acao_tipo').val(JSON.stringify(ploa.acao_tipo));
      $('#acao_tipo').select2().trigger('change');

      $('#tipo_acao').val(ploa.tipo_acao);

      $('#instituicao_id').val(ploa.instituicao_id);

      $('#valor').val(ploa.valor);

      $('.collpase-form').collapse('show');

      $('#subtitle').removeClass('subtitle-new');

      $('#subtitle').addClass('subtitle-edit');
      
      $('#subtitle').text('Edição');

      $('#novo-button').attr('disabled', true);

      $('#cancel-button').show();

      $('#form').attr('action', `/ploa/${ploa.id}`);
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

      $('#form').attr('action', `/ploa`);
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

    $(document).ready(function() {
        $('#exercicio_id').select2();
        $('#programa_id').select2();
        $('#fonte_tipo_id').select2();
        $('#acao_tipo').select2();
        $('#ploas').DataTable( {} );
    });
  </script>
@endsection