<?php

namespace App\Http\Transformers;

use App\Models\GrupoFonte;

class GrupoFonteTransformer
{

    public static function toInstance(array $input, $grupo_fonte = null)
    {
      if (empty($grupo_fonte)) {
        $grupo_fonte = new GrupoFonte();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'id':
            $grupo_fonte->id = $value;
            break;
          case 'nome':
            $grupo_fonte->nome = $value;
            break;
          case 'fav':
            $grupo_fonte->fav = $value;
            break;
        }
      }

      return $grupo_fonte;
    }
}