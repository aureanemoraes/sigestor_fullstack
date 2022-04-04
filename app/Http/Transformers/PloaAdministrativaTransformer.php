<?php

namespace App\Http\Transformers;

use App\Models\PloaAdministrativa;

class PloaAdministrativaTransformer
{

    public static function toInstance(array $input, $ploa_gestora, $ploa_administrativa = null)
    {
      if (empty($ploa_administrativa)) {
        $ploa_administrativa = new PloaAdministrativa();
      }

      $ploa_administrativa->ploa_gestora_id = $ploa_gestora->id;

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'unidade_administrativa_id':
            $ploa_administrativa->unidade_administrativa_id = $value;
            break;
          case 'valor':
            $ploa_administrativa->valor = $value;
            break;
        }
      }

      return $ploa_administrativa;
    }
}