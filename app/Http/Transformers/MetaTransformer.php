<?php

namespace App\Http\Transformers;

use App\Models\Meta;

class MetaTransformer
{

    public static function toInstance(array $input, $meta = null)
    {
      if (empty($meta)) {
        $meta = new Meta();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $meta->nome = $value;
            break;
          case 'descricao':
            $meta->descricao = $value;
            break;
          case 'tipo':
            $meta->tipo = $value;
            break;
          case 'tipo_dado':
            $meta->tipo_dado = $value;
            break;
          case 'valor_inicial':
            $meta->valor_inicial = $value;
            break;
          case 'valor_final':
            $meta->valor_final = $value;
            break;
          case 'valor_atingido':
            $meta->valor_atingido = $value;
            break;
          case 'objetivo_id':
            $meta->objetivo_id = $value;
            break;
          case 'plano_acao_id':
            $meta->plano_acao_id = $value;
            break;
        }
      }

      return $meta;
    }
}