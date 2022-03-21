<?php

namespace App\Http\Transformers;

use App\Models\CreditoDisponivel;

class CreditoDisponivelTransformer
{

    public static function toInstance(array $input, $credito_disponivel = null)
    {
      if (empty($credito_disponivel)) {
        $credito_disponivel = new CreditoDisponivel();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'descricao':
            $credito_disponivel->descricao = $value;
            break;
          case 'valor_solicitado':
            $credito_disponivel->valor_solicitado = $value;
            break;
          case 'valor_disponivel':
            $credito_disponivel->valor_disponivel = $value;
            break;
          case 'despesa_id':
            $credito_disponivel->despesa_id = $value;
            break;
          case 'unidade_administrativa_id':
            $credito_disponivel->unidade_administrativa_id = $value;
            break;
        }
      }

      return $credito_disponivel;
    }
}