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
          case 'qtd_estimada':
            $meta_orcamentaria->qtd_estimada = $value;
            break;
          case 'qtd_alcancada':
            $meta_orcamentaria->qtd_alcancada = $value;
            break;
          case 'acao_id':
            $meta_orcamentaria->acao_id = $value;
            break;
          case 'natureza_despesa_id':
            $meta_orcamentaria->natureza_despesa_id = $value;
            break;
          case 'instituicao_id':
            $meta_orcamentaria->instituicao_id = $value;
            break;
          case 'unidade_gestora_id':
            $meta_orcamentaria->unidade_gestora_id = $value;
            break;
          case 'exercicio_id':
            $meta_orcamentaria->exercicio_id = $value;
            break;
        }
      }

      return $meta_orcamentaria;
    }
}