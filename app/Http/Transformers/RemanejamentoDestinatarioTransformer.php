<?php

namespace App\Http\Transformers;

use App\Models\RemanejamentoDestinatario;

class RemanejamentoDestinatarioTransformer
{

    public static function toInstance(array $input, $remanejamento_destinatario = null)
    {
      if (empty($remanejamento_destinatario)) {
        $remanejamento_destinatario = new RemanejamentoDestinatario();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
            case 'valor_remanejamento':
                $remanejamento_destinatario->valor = $value;
                break;
            case 'remanejamento_id':
                $remanejamento_destinatario->remanejamento_id = $value;
                break;
            case 'despesa_destinatario_id':
                $remanejamento_destinatario->despesa_destinatario_id = $value;
                break;
        }
      }

      return $remanejamento_destinatario;
    }
}