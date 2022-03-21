<?php

namespace App\Http\Transformers;

use App\Models\AcaoTipo;

class AcaoTipoTransformer
{

    public static function toInstance(array $input, $acao_tipo = null)
    {
      if (empty($acao_tipo)) {
        $acao_tipo = new AcaoTipo();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'codigo':
            $acao_tipo->codigo = $value;
            break;
          case 'nome':
            $acao_tipo->nome = $value;
            break;
          case 'custeio':
            $acao_tipo->custeio = $value;
            break;
          case 'investimento':
            $acao_tipo->investimento = $value;
            break;
          case 'fav':
            $acao_tipo->fav = $value;
            break;
        }
      }

      return $acao_tipo;
    }
}