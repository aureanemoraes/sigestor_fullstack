<?php

namespace App\Http\Transformers;

use App\Models\Empenho;

class EmpenhoTransformer
{

    public static function toInstance(array $input, $empenho = null)
    {
      if (empty($empenho)) {
        $empenho = new Empenho();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'valor_empenhado':
            $empenho->valor_empenhado = $value;
            break;
          case 'data_empenho':
            $empenho->data_empenho = $value;
            break;
          case 'credito_disponivel_id':
            $empenho->credito_disponivel_id = $value;
            break;
          case 'unidade_administrativa_id':
            $empenho->unidade_administrativa_id = $value;
            break;
        }
      }

      return $empenho;
    }
}