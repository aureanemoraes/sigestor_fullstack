<?php

namespace App\Http\Transformers;

use App\Models\Instituicao;

class InstituicaoTransformer
{

    public static function toInstance(array $input, $instituicao = null)
    {
      if (empty($instituicao)) {
        $instituicao = new Instituicao();
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $instituicao->nome = $value;
            break;
          case 'sigla':
            $instituicao->sigla = $value;
            break;
          case 'cnpj':
            $instituicao->cnpj = $value;
            break;
          case 'uasg':
            $instituicao->uasg = $value;
            break;
          case 'logradouro':
            $instituicao->logradouro = $value;
            break;
          case 'numero':
            $instituicao->numero = $value;
            break;
          case 'bairro':
            $instituicao->bairro = $value;
            break;
          case 'complemento':
            $instituicao->complemento = $value;
            break;
        }
      }

      return $instituicao;
    }
}