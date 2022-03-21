<?php

namespace App\Http\Transformers;

use App\Models\FonteAcao;

class FonteAcaoTransformer
{

    public static function toInstance(array $input, $fonte_acao = null)
    {
      if (empty($fonte_acao)) {
        $fonte_acao = new FonteAcao();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'fonte_id':
            $fonte_acao->fonte_id = $value;
            break;
          case 'acao_id':
            $fonte_acao->acao_id = $value;
            break;
          case 'exercicio_id':
            $fonte_acao->exercicio_id = $value;
            break;
          case 'valor':
            $fonte_acao->valor = $value;
            break;
          case 'instituicao_id':
            $fonte_acao->instituicao_id = $value;
            break;
          case 'unidade_gestora_id':
            $fonte_acao->unidade_gestora_id = $value;
            break;
          case 'unidade_administrativa_id':
            $fonte_acao->unidade_administrativa_id = $value;
            break;
        }
      }

      return $fonte_acao;
    }
}