<?php

namespace App\Http\Transformers;

use App\Models\NaturezaDespesa;

class NaturezaDespesaTransformer
{

    public static function toInstance(array $input, $natureza_despesa_tipo = null)
    {
      if (empty($natureza_despesa_tipo)) {
        $natureza_despesa_tipo = new NaturezaDespesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $natureza_despesa_tipo->nome = $value;
            break;
          case 'codigo':
            $natureza_despesa_tipo->codigo = $value;
            break;
          case 'tipo':
            $natureza_despesa_tipo->tipo = $value;
            break;
          case 'fav':
            $natureza_despesa_tipo->fav = $value;
            break;
        }
      }

      return $natureza_despesa_tipo;
    }
}