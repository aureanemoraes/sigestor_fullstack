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
            case 'qtd':
                $remanejamento->qtd = $value;
                break;
            case 'valor':
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
            case 'despesa_destinatario_id':
                $remanejamento->despesa_destinatario_id = $value;
                break;
        }
      }

      return $remanejamento;
    }
}