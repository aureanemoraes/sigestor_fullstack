<?php

namespace App\Http\Transformers;

use App\Models\SubnaturezaDespesa;

class SubnaturezaDespesaTransformer
{

    public static function toInstance(array $input, $subnatureza_despesa_tipo = null)
    {
      if (empty($subnatureza_despesa_tipo)) {
        $subnatureza_despesa_tipo = new SubnaturezaDespesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'codigo':
            $subnatureza_despesa_tipo->codigo = $value;
            break;
          case 'nome':
            $subnatureza_despesa_tipo->nome = $value;
            break;
          case 'natureza_despesa_id':
            $subnatureza_despesa_tipo->natureza_despesa_id = $value;
            break;
        }
      }

      return $subnatureza_despesa_tipo;
    }
}