<?php

namespace App\Http\Transformers;

use App\Models\SubnaturezaDespesa;

class SubnaturezaDespesaTransformer
{

    public static function toInstance(array $input, $subnatureza_despesa = null)
    {
      if (empty($subnatureza_despesa)) {
        $subnatureza_despesa = new SubnaturezaDespesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'codigo':
            $subnatureza_despesa->codigo = $value;
            break;
          case 'nome':
            $subnatureza_despesa->nome = $value;
            break;
          case 'natureza_despesa_id':
            $subnatureza_despesa->natureza_despesa_id = $value;
            break;
          case 'fields':
            $subnatureza_despesa->fields = $value;
            break;
        }
      }

      return $subnatureza_despesa;
    }
}