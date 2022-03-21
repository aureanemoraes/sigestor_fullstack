<?php

namespace App\Http\Transformers;

use App\Models\FonteTipo;

class FonteTipoTransformer
{

    public static function toInstance(array $input, $fonte_tipo = null)
    {
      if (empty($fonte_tipo)) {
        $fonte_tipo = new FonteTipo();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'grupo_fonte_id':
            $fonte_tipo->grupo_fonte_id = $value;
            break;
          case 'especificacao_id':
            $fonte_tipo->especificacao_id = $value;
            break;
          case 'nome':
            $fonte_tipo->nome = $value;
            break;
          case 'fav':
            $fonte_tipo->fav = $value;
            break;
        }
      }

      $fonte_tipo->codigo = null;

      return $fonte_tipo;
    }
}