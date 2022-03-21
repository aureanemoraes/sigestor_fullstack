<?php

namespace App\Http\Transformers;

use App\Models\Programa;

class ProgramaTransformer
{

    public static function toInstance(array $input, $programa = null)
    {
      if (empty($programa)) {
        $programa = new Programa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'codigo':
            $programa->codigo = $value;
            break;
          case 'nome':
            $programa->nome = $value;
            break;
          case 'fav':
            $programa->fav = $value;
            break;
        }
      }

      return $programa;
    }
}