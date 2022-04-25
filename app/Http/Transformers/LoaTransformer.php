<?php

namespace App\Http\Transformers;

use App\Models\Loa;

class LoaTransformer
{

    public static function toInstance(array $input, $loa = null)
    {
      if (empty($loa)) {
        $loa = new Loa();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'descricao':
            $loa->descricao = $value;
            break;
          case 'tipo':
            $loa->tipo = $value;
            break;
          case 'valor':
            $loa->valor = $value;
            break;
          case 'ploa_id':
            $loa->ploa_id = $value;
            break;
        case 'data_recebimento':
            $loa->data_recebimento = $value;
            break;
        }
      }

      return $loa;
    }
}