<?php

namespace App\Http\Transformers;

use App\Models\Ploa;

class PloaTransformer
{

    public static function toInstance(array $input, $ploa = null)
    {
      if (empty($ploa)) {
        $ploa = new Ploa();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'exercicio_id':
            $ploa->exercicio_id = $value;
            break;
          case 'programa_id':
            $ploa->programa_id = $value;
            break;
          case 'fonte_tipo_id':
            $ploa->fonte_tipo_id = $value;
            break;
          case 'acao_tipo_id':
            $ploa->acao_tipo_id = $value;
            break;
          case 'instituicao_id':
            $ploa->instituicao_id = $value;
            break;
          case 'tipo_acao':
            $ploa->tipo_acao = $value;
            break;
          case 'valor':
            $ploa->valor = $value;
            break;
        }
      }

      return $ploa;
    }
}