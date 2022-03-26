<?php

namespace App\Http\Transformers;

use App\Models\Evento;

class EventoTransformer
{
    public static function toInstance(array $input, $evento = null)
    {
      if (empty($evento)) {
        $evento = new Evento();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $evento->nome = $value;
            break;
          case 'data_inicio':
            $evento->data_inicio = $value;
            break;
          case 'data_fim':
            $evento->data_fim = $value;
            break;
          case 'agenda_id':
            $evento->agenda_id = $value;
            break;
        }
      }

      return $evento;
    }
}