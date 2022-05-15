<?php

namespace App\Http\Transformers;

use App\Models\Remanejamento;

class RemanejamentoTransformer
{

    public static function toInstance(array $input, $remanejamento = null)
    {
      if (empty($remanejamento)) {
        $remanejamento = new Remanejamento();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
            case 'valor_remanejamento':
                $remanejamento->valor = $value;
                break;
            case 'numero_oficio':
                $remanejamento->numero_oficio = $value;
                break;
            case 'data':
                $remanejamento->data = $value;
                break;
            case 'despesa_remetente_id':
                $remanejamento->despesa_remetente_id = $value;
                break;
            case 'unidade_gestora_id':
              $remanejamento->unidade_gestora_id = $value;
              break;
            case 'instituicao_id':
              $remanejamento->instituicao_id = $value;
              break;
        }
      }

      return $remanejamento;
    }
}