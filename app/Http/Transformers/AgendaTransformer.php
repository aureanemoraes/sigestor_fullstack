<?php

namespace App\Http\Transformers;

use App\Models\Agenda;

class AgendaTransformer
{
    public static function toInstance(array $input, $agenda = null)
    {
      if (empty($agenda)) {
        $agenda = new Agenda();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $agenda->nome = $value;
            break;
          case 'data_inicio':
            $agenda->data_inicio = $value;
            break;
          case 'data_fim':
            $agenda->data_fim = $value;
            break;
          case 'status':
            $agenda->status = $value;
            break;
          case 'exercicio_id':
            $agenda->exercicio_id = $value;
            break;
        }
      }

      return $agenda;
    }
}