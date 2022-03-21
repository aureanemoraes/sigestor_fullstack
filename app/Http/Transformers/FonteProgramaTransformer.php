<?php

namespace App\Http\Transformers;

use App\Models\FontePrograma;

class FonteProgramaTransformer
{

    public static function toInstance(array $input, $fonte_programa = null)
    {
      if (empty($fonte_programa)) {
        $fonte_programa = new FontePrograma();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'fonte_id':
            $fonte_programa->fonte_id = $value;
            break;
          case 'programa_id':
            $fonte_programa->programa_id = $value;
            break;
          case 'exercicio_id':
            $fonte_programa->exercicio_id = $value;
            break;
        }
      }

      return $fonte_programa;
    }
}