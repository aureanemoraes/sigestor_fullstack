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
            case 'tipo':
                $despesa->tipo = $value;
                break;
            case 'ploa_administrativa_id':
                $despesa->ploa_administrativa_id = $value;
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
            case 'meta_id':
            $despesa->meta_id = $value;
                break;
            case 'exercicio_id':
            $despesa->exercicio_id = $value;
                break;
            case 'fields':
                $despesa->fields = $value;
                break;
            case 'valor':
                $despesa->valor = $value;
                break;
            case 'despesa_modelo_id':
                $despesa->despesa_modelo_id = $value;
                break;
        }
      }

      if(!isset($input['fields']))
        $despesa->fields = null;

        $despesa->valor_total = 0;


      return $despesa;
    }
}