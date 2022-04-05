<?php

namespace App\Http\Transformers;

use App\Models\SubnaturezaDespesa;

class SubnaturezaDespesaTransformer
{

    public static function toInstance(array $input, $subnatureza_despesa = null)
    {
      if (empty($subnatureza_despesa)) {
        $subnatureza_despesa = new SubnaturezaDespesa();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'codigo':
            $subnatureza_despesa->codigo = $value;
            break;
          case 'nome':
            $subnatureza_despesa->nome = $value;
            break;
          case 'natureza_despesa_id':
            $subnatureza_despesa->natureza_despesa_id = $value;
            break;
          case 'fields':
            $fields = [];
            foreach($value as $key => $field) {
              $fields[$key]['label'] = $field;
              $fields[$key]['slug'] = slug($field);
            }
            $subnatureza_despesa->fields = $fields;
            break;
        }
      }

      if(!isset($input['fields']))
        $subnatureza_despesa->fields = null;

      return $subnatureza_despesa;
    }
}