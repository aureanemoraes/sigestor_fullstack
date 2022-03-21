<?php

namespace App\Http\Transformers;

use App\Models\Despesa;

class DespesaTransformer
{

    public static function toInstance(array $input, $despesa = null)
    {
      if (empty($despesa)) {
        $despesa = new Despesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'descricao':
            $despesa->descricao = $value;
            break;
          case 'valor':
            $despesa->valor = $value;
            $despesa->valor_total = $value;
            break;
          case 'qtd':
            $despesa->qtd = $value;
            break;
          case 'qtd_pessoas':
            $despesa->qtd_pessoas = $value;
            break;
          case 'tipo':
            $despesa->tipo = $value;
            break;
          case 'fonte_acao_id':
            $despesa->fonte_acao_id = $value;
            break;
          case 'centro_custo_id':
            $despesa->centro_custo_id = $value;
            break;
          case 'natureza_despesa_id':
            $despesa->natureza_despesa_id = $value;
            break;
          case 'subnatureza_despesa_id':
            $despesa->subnatureza_despesa_id = $value;
            break;
          case 'unidade_administrativa_id':
            $despesa->unidade_administrativa_id = $value;
            break;
        }
      }

      return $despesa;
    }
}