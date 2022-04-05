<?php

namespace App\Http\Transformers;

use App\Models\DespesaModelo;

class DespesaModeloTransformer
{

    public static function toInstance(array $input, $despesa_modelo = null)
    {
      if (empty($despesa_modelo)) {
        $despesa_modelo = new DespesaModelo();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
            case 'descricao':
                $despesa_modelo->descricao = $value;
                break;
            case 'tipo':
                $despesa_modelo->tipo = $value;
                break;
            case 'ploa_administrativa_id':
                $despesa_modelo->ploa_administrativa_id = $value;
                break;
            case 'centro_custo_id':
            $despesa_modelo->centro_custo_id = $value;
                break;
            case 'natureza_despesa_id':
            $despesa_modelo->natureza_despesa_id = $value;
                break;
            case 'subnatureza_despesa_id':
                $despesa_modelo->subnatureza_despesa_id = $value;
                break;
            case 'unidade_administrativa_id':
                $despesa_modelo->unidade_administrativa_id = $value;
                break;
            case 'meta_id':
            $despesa_modelo->meta_id = $value;
                break;
            case 'exercicio_id':
            $despesa_modelo->exercicio_id = $value;
                break;
            case 'fields':
                $despesa_modelo->fields = $value;
                break;
            case 'valor':
                $despesa_modelo->valor = $value;
                break;
        }
      }

      if(!isset($input['fields']))
        $despesa_modelo->fields = null;

        $despesa_modelo->valor_total = 0;


      return $despesa_modelo;
    }
}