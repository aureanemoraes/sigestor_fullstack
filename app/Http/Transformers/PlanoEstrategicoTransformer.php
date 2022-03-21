<?php

namespace App\Http\Transformers;

use App\Models\PlanoEstrategico;

class PlanoEstrategicoTransformer
{

    public static function toInstance(array $input, $plano_estrategico = null)
    {
      if (empty($plano_estrategico)) {
        $plano_estrategico = new PlanoEstrategico();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'nome':
            $plano_estrategico->nome = $value;
            break;
          case 'data_inicio':
            $plano_estrategico->data_inicio = $value;
            break;
          case 'data_fim':
            $plano_estrategico->data_fim = $value;
            break;
          case 'instituicao_id':
            $plano_estrategico->instituicao_id = $value;
            break;
        }
      }

      return $plano_estrategico;
    }
}