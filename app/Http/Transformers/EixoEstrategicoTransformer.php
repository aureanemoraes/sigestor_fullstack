<?php

namespace App\Http\Transformers;

use App\Models\EixoEstrategico;

class EixoEstrategicoTransformer
{

    public static function toInstance(array $input, $eixo_estrategico = null)
    {
      if (empty($eixo_estrategico)) {
        $eixo_estrategico = new EixoEstrategico();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'nome':
            $eixo_estrategico->nome = $value;
            break;
          case 'plano_estrategico_id':
            $eixo_estrategico->plano_estrategico_id = $value;
            break;
          case 'instituicao_id':
            $eixo_estrategico->instituicao_id = $value;
            break;
        }
      }

      return $eixo_estrategico;
    }
}