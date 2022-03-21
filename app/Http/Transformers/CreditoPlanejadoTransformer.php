<?php

namespace App\Http\Transformers;

use App\Models\CreditoPlanejado;

class CreditoPlanejadoTransformer
{

    public static function toInstance(array $input, $credito_planejado = null)
    {
      if (empty($credito_planejado)) {
        $credito_planejado = new CreditoPlanejado();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'descricao':
            $credito_planejado->descricao = $value;
            break;
          case 'valor_solicitado':
            $credito_planejado->valor_solicitado = $value;
            break;
          case 'valor_disponivel':
            $credito_planejado->valor_disponivel = $value;
            break;
          case 'despesa_id':
            $credito_planejado->despesa_id = $value;
            break;
          case 'unidade_administrativa_id':
            $credito_planejado->unidade_administrativa_id = $value;
            break;
        }
      }

      return $credito_planejado;
    }
}