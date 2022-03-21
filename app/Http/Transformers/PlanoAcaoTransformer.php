<?php

namespace App\Http\Transformers;

use App\Models\PlanoAcao;

class PlanoAcaoTransformer
{

    public static function toInstance(array $input, $plano_acao = null)
    {
      if (empty($plano_acao)) {
        $plano_acao = new PlanoAcao();
      }

      foreach ($input as $key => $value) {
      switch ($key) {
          case 'nome':
            $plano_acao->nome = $value;
            break;
          case 'data_inicio':
            $plano_acao->data_inicio = $value;
            break;
          case 'data_fim':
            $plano_acao->data_fim = $value;
            break;
          case 'plano_estrategico_id':
            $plano_acao->plano_estrategico_id = $value;
            break;
          case 'instituicao_id':
            $plano_acao->instituicao_id = $value;
            break;
        }
      }

      return $plano_acao;
    }
}