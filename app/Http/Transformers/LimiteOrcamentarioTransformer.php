<?php

namespace App\Http\Transformers;

use App\Models\LimiteOrcamentario;

class LimiteOrcamentarioTransformer
{

    public static function toInstance(array $input, $limite_orcamentario = null)
    {
      if (empty($limite_orcamentario)) {
        $limite_orcamentario = new LimiteOrcamentario();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'descricao':
            $limite_orcamentario->descricao = $value;
            break;
          case 'valor_solicitado':
            $limite_orcamentario->valor_solicitado = $value;
            break;
          case 'valor_disponivel':
            $limite_orcamentario->valor_disponivel = $value;
            break;
          case 'numero_processo':
            $limite_orcamentario->numero_processo = $value;
            break;
          case 'despesa_id':
            $limite_orcamentario->despesa_id = $value;
            break;
          case 'unidade_administrativa_id':
            $limite_orcamentario->unidade_administrativa_id = $value;
            break;
        }
      }

      return $limite_orcamentario;
    }
}