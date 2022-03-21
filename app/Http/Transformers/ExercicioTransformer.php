<?php

namespace App\Http\Transformers;

use App\Models\Exercicio;

class ExercicioTransformer
{

    public static function toInstance(array $input, $exercicio = null)
    {
      if (empty($exercicio)) {
        $exercicio = new Exercicio();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $exercicio->nome = $value;
            break;
          case 'data_inicio':
            $exercicio->data_inicio = $value;
            break;
          case 'data_fim':
            $exercicio->data_fim = $value;
            break;
          case 'instituicao_id':
            $exercicio->instituicao_id = $value;
            break;
        }
      }

      return $exercicio;
    }
}