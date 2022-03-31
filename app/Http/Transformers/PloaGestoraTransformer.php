<?php

namespace App\Http\Transformers;

use App\Models\PloaGestora;

class PloaGestoraTransformer
{

    public static function toInstance(array $input, $ploa, $ploa_gestora = null)
    {
      if (empty($ploa_gestora)) {
        $ploa_gestora = new PloaGestora();
      }

      $ploa_gestora->ploa_id = $ploa->id;

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'unidade_gestora_id':
            $ploa_gestora->unidade_gestora_id = $value;
            break;
          case 'valor':
            $ploa_gestora->valor = $value;
            break;
        }
      }

      return $ploa_gestora;
    }
}