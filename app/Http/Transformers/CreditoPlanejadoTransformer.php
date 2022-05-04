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
          case 'codigo_processo':
            $credito_planejado->codigo_processo = $value;
            break;
          case 'despesa_id':
            $credito_planejado->despesa_id = $value;
            break;
          case 'unidade_gestora':
            $credito_planejado->unidade_gestora = $value;
            break;
          case 'instituicao':
            $credito_planejado->instituicao = $value;
            break;
          case 'solicitado':
            $credito_planejado->solicitado = $value;
            break;
        }
      }

      return $credito_planejado;
    }
}