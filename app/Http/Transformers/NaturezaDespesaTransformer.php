<?php

namespace App\Http\Transformers;

use App\Models\NaturezaDespesa;

class NaturezaDespesaTransformer
{

    public static function toInstance(array $input, $natureza_despesa = null)
    {
      if (empty($natureza_despesa)) {
        $natureza_despesa = new NaturezaDespesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $natureza_despesa->nome = $value;
            break;
          case 'codigo':
            $natureza_despesa->codigo = $value;
            break;
          case 'tipo':
            $natureza_despesa->tipo = $value;
            break;
          case 'fav':
            $natureza_despesa->fav = $value;
            break;
          case 'fields':
            $natureza_despesa->fields = $value;
            break;
        }
      }

      return $natureza_despesa;
    }
}