@extends('layouts.app')

@section('content')
  @include('remanejamento_destinatario.form')
@endsection

@section('js')
  <script>
    $('#unidade_gestora_id').on('change', () => {
        let exercicio_id = $('#exercicio_id').val();
        let unidade_gestora_id = $('#unidade_gestora_id').val();
        let unidade_administrativa_id = $('#unidade_administrativa_id').val();
        let remanejamento_id = $('#remanejamento_id').val();
        if(unidade_gestora_id)
            window.location.href = `/remanejamento_destinatario/create?tipo=1&ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}&unidade_administrativa=${unidade_administrativa_id}&remanejamento=${remanejamento_id}`;
    });

    $('#unidade_administrativa_id').on('change', () => {
        let exercicio_id = $('#exercicio_id').val();
        let unidade_gestora_id = $('#unidade_gestora_id').val();
        let unidade_administrativa_id = $('#unidade_administrativa_id').val();
        let remanejamento_id = $('#remanejamento_id').val();
        if(unidade_gestora_id)
            window.location.href = `/remanejamento_destinatario/create?tipo=1&ploa=${exercicio_id}&unidade_gestora=${unidade_gestora_id}&unidade_administrativa=${unidade_administrativa_id}&remanejamento=${remanejamento_id}`;
    });
    // remanejamento?ploa=2&unidade_gestora=1
  </script>
  <script>

    function getDespesaId(str) {
      let array = str.split('-');
      let index = array.length - 1;
      return str.split('-')[index];
    }

    function retornaQuantidade(despesa_id) {
      let qtd_id = despesa_id;
      let coringa = $('.quantidades').map(function(){
        if(this.id == qtd_id)
          return $(this).val();
        else
          return 1;
      }).get();



      let valores = coringa.map(y => parseInt(y));

      let reducer = (accumulator, x) => accumulator * x;

      let quantidade = valores.reduce(reducer);

      return quantidade;
    }

    $(document).on('change','.quantidades', function() {
      let despesa_id = getDespesaId(this.id);

      let valor = $(`#valor-${despesa_id}`).val();
      let valorTotal = $(`#valor-total-inicial-${despesa_id}`).val();

      let quantidade = retornaQuantidade(this.id);
      let limiteRemanejamentoInicial = $('#limite_remanejamento_inicial').val();
      let limiteRemanejamento = $('#limite_remanejamento').val();

      let novoValorTotal = valor * quantidade;
      let valorRemanejamento = novoValorTotal - valorTotal;

      if(valorRemanejamento > limiteRemanejamento) {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-success');
        $(`#valor-remanejamento-text-${despesa_id}`).addClass('bg-danger');
      } else if(valorRemanejamento == 0) {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-success');
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-danger');
      } else {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-danger');
        $(`#valor-remanejamento-text-${despesa_id}`).addClass('bg-success');
      }

      $('#limite_remanejamento').val(limiteRemanejamento);
      $('#limite_remanejamento_text').text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(limiteRemanejamento)}`);


      $(`#valor-total-text-${despesa_id}`).text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(novoValorTotal)}`);

      $(`#valor-total-${despesa_id}`).val(novoValorTotal);

      $(`#valor-remanejamento-${despesa_id}`).val(valorRemanejamento);

      $(`#valor-remanejamento-text-${despesa_id}`).text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valorRemanejamento)}`);

    });

    $(document).on('change','.valor', function() {
      let despesa_id = getDespesaId(this.id);
      console.log(despesa_id);

      let quantidade = retornaQuantidade(despesa_id);
      let valorTotal = $(`#valor-total-inicial-${despesa_id}`).val();
      let novoValorTotal = $(`#valor-${despesa_id}`).val() * quantidade;
      let limiteRemanejamento = $('#limite_remanejamento').val();
      let valorRemanejamento = novoValorTotal - valorTotal;

      if(valorRemanejamento > limiteRemanejamento) {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-success');
        $(`#valor-remanejamento-text-${despesa_id}`).addClass('bg-danger');
      } else if(valorRemanejamento == 0) {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-success');
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-danger');
      } else {
        $(`#valor-remanejamento-text-${despesa_id}`).removeClass('bg-danger');
        $(`#valor-remanejamento-text-${despesa_id}`).addClass('bg-success');
      }

      $(`#valor-total-text-${despesa_id}`).text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(novoValorTotal)}`);

      $(`#valor-total-${despesa_id}`).val(novoValorTotal);

      $(`#valor-remanejamento-${despesa_id}`).val(valorRemanejamento);

      $(`#valor-remanejamento-text-${despesa_id}`).text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valorRemanejamento)}`);
    });

    // $('#unidade_administrativa_id').on('change', function() {

    //   let unidade_administrativa_id = $(this).val();
    //   let ploa_id = $('#exercicio_id').val();

    //   getDespesas(unidade_administrativa_id, ploa_id);
    // });

    // $('#unidade_administrativa_id').on('change', function() {
    //   let id = $(this).val();
    //   let ploa_id = $('#exercicio_id').val();
    //   $('#acao_tipo_id').empty().trigger("change");
    //   $('#acao_tipo_id').select2({data: [
    //     {id: '', text: '-- selecione --'}
    //   ]});
    //   $('#natureza_despesa_id').empty().trigger("change");
    //   $('#natureza_despesa_id').select2({data: [
    //     {id: '', text: '-- selecione --'}
    //   ]});
    //   getOptionsAcoes('acao/options', id, ploa_id, '#acao_tipo_id');
    // });

    // $('#acao_tipo_id').on('change', function() {
    //   let id = $('#unidade_administrativa_id').val();
    //   let acao_id = $(this).val();
    //   let ploa_id = $('#exercicio_id').val();
    //   getOptionsNaturezas('natureza_despesa/options', id, ploa_id, acao_id, '#natureza_despesa_id');
    // });

    $(function() {
      $('#acao_tipo_id').select2({});
      $('#natureza_despesa_id').select2({});
      $('#fonte_tipo_id').select2({});
      $('#despesas').DataTable({});
    });
    
  </script>
@endsection
