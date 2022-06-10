<?php

namespace App\Http\Transformers;

use App\Models\MetaOrcamentaria;

class MetaOrcamentariaTransformer
{

    public static function toInstance(array $input, $meta_orcamentaria = null)
    {
      if (empty($meta_orcamentaria)) {
        $meta_orcamentaria = new MetaOrcamentaria();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $meta_orcamentaria->nome = $value;
            break;
          case 'acao_tipo_id':
            $meta_orcamentaria->acao_tipo_id = $value;
            break;
          case 'natureza_despesa_id':
            $meta_orcamentaria->natureza_despesa_id = $value;
            break;
          case 'field':
            $meta_orcamentaria->field = $value;
            break;
        }
      }

      if(!isset($input['field']))
        $meta_orcamentaria->field = null;

      return $meta_orcamentaria;
    }
}