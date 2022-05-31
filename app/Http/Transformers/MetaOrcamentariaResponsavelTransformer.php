<?php

namespace App\Http\Transformers;

use App\Models\MetaOrcamentariaResponsavel;

class MetaOrcamentariaResponsavelTransformer
{

    public static function toInstance(array $input, $meta_orcamentaria_responsavel = null)
    {
      if (empty($meta_orcamentaria_responsavel)) {
        $meta_orcamentaria_responsavel = new MetaOrcamentariaResponsavel();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'meta_orcamentaria_id':
            $meta_orcamentaria_responsavel->meta_orcamentaria_id = $value;
            break;
          case 'unidade_gestora_id':
            $meta_orcamentaria_responsavel->unidade_gestora_id = $value;
            break;
          case 'exercicio_id':
            $meta_orcamentaria_responsavel->exercicio_id = $value;
            break;
          
        }
      }

      return $meta_orcamentaria_responsavel;
    }
}