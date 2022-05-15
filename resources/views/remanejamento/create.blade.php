@extends('layouts.app')

@section('content')
  @include('remanejamento.form')
@endsection

@section('js')
  <script>

    // function teste(data) {
    //   if ( $.fn.DataTable.isDataTable('#despesas') ) {
    //     $('#despesas').DataTable().destroy();
    //   }

    //   $('#despesas tbody').empty();

    //   // ... skipped ...

    //   $('#despesas').dataTable({
    //         "autoWidth":false, 
    //         "info":false, 
    //         "JQueryUI":true, 
    //         "ordering":true, 
    //         "paging":false, 
    //         "scrollY":"500px", 
    //         "scrollCollapse":true,
    //         data: data,
    //         columns: [
    //             { title: 'Id' },
    //             { title: 'Descricao' }
    //         ],
    //   });
    // }

    // function getDespesas(unidade_administrativa_id, ploa_id) {
    //   let dados = [];
    //     $.ajax({
    //       method: "GET",
    //       url: `/api/despesa/${unidade_administrativa_id}/${ploa_id}`,
    //     }).done(function(response) {
    //       teste(response);
    //     });
    // }

    // function getOptionsAcoes(base, id, ploa_id, element_id) {
    //   let dados = [];
    //     $.ajax({
    //       method: "GET",
    //       url: `/api/${base}/${id}/unidade_administrativa/${ploa_id}`,
    //     }).done(function(response) {
    //       console.log(element_id, response);
    //       $(element_id).select2({data:response});
    //     });
    // }

    // function getOptionsNaturezas(base, id, ploa_id, acao_id, element_id) {
    //   let dados = [];
    //     $.ajax({
    //       method: "GET",
    //       url: `/api/${base}/${id}/${acao_id}/unidade_administrativa/${ploa_id}`,
    //     }).done(function(response) {
    //       console.log(element_id, response);
    //       $(element_id).select2({data:response});
    //     });
    // }

    function retornaQuantidade() {
      let coringa = $('.quantidades').map(function(){
        return $(this).val();
      }).get();

      let valores = coringa.map(y => parseInt(y));

      if(valores.length > 0) {
        let reducer = (accumulator, x) => accumulator * x;

        let quantidade = valores.reduce(reducer);

        return quantidade;

      } else {
        return 1;
      }

    }

    $(document).on('change','.quantidades', function() {
      let valor = $('#valor').val();
      let valorTotal = $('#valor-total-inicial').val();

      let quantidade = retornaQuantidade();

      let novoValorTotal = valor * quantidade;
      let valorRemanejamento = valorTotal - novoValorTotal;

      $('#valor-total-text').text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(novoValorTotal)}`);

      $('#valor-total').val(novoValorTotal);

      $('#valor-remanejamento').val(valorRemanejamento);

      $('#valor-remanejamento-text').text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valorRemanejamento)}`);

    });

    $('#valor').on('change', function() {
      let quantidade = retornaQuantidade();
      let valorTotal = $('#valor-total-inicial').val();
      let novoValorTotal = $(this).val() * quantidade;
      let valorRemanejamento = valorTotal - novoValorTotal;

      $('#valor-total-text').text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(novoValorTotal)}`);

      $('#valor-total').val(novoValorTotal);

      $('#valor-remanejamento').val(valorRemanejamento);

      $('#valor-remanejamento-text').text(`${ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valorRemanejamento)}`);
      
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
