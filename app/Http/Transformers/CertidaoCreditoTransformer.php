<?php

namespace App\Http\Transformers;

use App\Models\CertidaoCredito;

class CertidaoCreditoTransformer
{

    public static function toInstance(array $input, $certidao_credito = null)
    {
      if (empty($certidao_credito)) {
        $certidao_credito = new CertidaoCredito();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'credito_planejado_id':
            $certidao_credito->credito_planejado_id = $value;
            break;
        }
      }

      
      $certidao_credito->codigo_certidao = '';

      return $certidao_credito;
    }
}