<?php

namespace App\Http\Transformers;

use App\Models\Empenho;

class EmpenhoTransformer
{

    public static function toInstance(array $input, $empenho = null)
    {
      if (empty($empenho)) {
        $empenho = new Empenho();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'notas_fiscais':
            $empenho->notas_fiscais = $value;
            break;
          case 'certidao_credito_id':
            $empenho->certidao_credito_id = $value;
            break;
        }
      }

      if(!isset($input['notas_fiscais']))
        $empenho->notas_fiscais = null;

      return $empenho;
    }
}