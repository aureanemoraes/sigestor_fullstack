<?php

namespace App\Http\Transformers;

use App\Models\Movimento;

class MovimentoTransformer
{

    public static function toInstance(array $input, $movimento = null)
    {
      if (empty($movimento)) {
        $movimento = new Movimento();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'descricao':
            $movimento->descricao = $value;
            break;
          case 'valor':
            $movimento->valor = $value;
            break;
          case 'exercicio_id':
            $movimento->exercicio_id = $value;
            break;
          case 'tipo':
            $movimento->tipo = $value;
            break;
        }
      }

      return $movimento;
    }
}