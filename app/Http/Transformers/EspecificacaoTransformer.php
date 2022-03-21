<?php

namespace App\Http\Transformers;

use App\Models\Especificacao;

class EspecificacaoTransformer
{

    public static function toInstance(array $input, $especificacao = null)
    {
      if (empty($especificacao)) {
        $especificacao = new Especificacao();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'id':
            $especificacao->id = $value;
            break;
          case 'nome':
            $especificacao->nome = $value;
            break;
          case 'fav':
            $especificacao->fav = $value;
            break;
        }
      }

      return $especificacao;
    }
}