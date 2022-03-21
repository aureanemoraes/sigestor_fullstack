<?php

namespace App\Http\Transformers;

use App\Models\UnidadeGestora;

class UnidadeGestoraTransformer
{

    public static function toInstance(array $input, $unidade_gestora = null)
    {
      $logs = [];
      if (empty($unidade_gestora)) {
        $unidade_gestora = new UnidadeGestora();
      } 

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $unidade_gestora->nome = $value;
            break;
          case 'sigla':
            $unidade_gestora->sigla = $value;
            break;
          case 'logradouro':
            $unidade_gestora->logradouro = $value;
            break;
          case 'numero':
            $unidade_gestora->numero = $value;
            break;
          case 'bairro':
            $unidade_gestora->bairro = $value;
            break;
          case 'complemento':
            $unidade_gestora->complemento = $value;
            break;
          case 'cnpj':
            $unidade_gestora->cnpj = $value;
            break;
          case 'uasg':
            $unidade_gestora->uasg = $value;
            break;
          case 'instituicao_id':
            $unidade_gestora->instituicao_id = $value;
            break;
        }
      }

      if(isset($unidade_gestora->logs)) {
        foreach($unidade_gestora->logs as $log) {
          $logs[] = $log;
        } 
      }
      $model = $unidade_gestora->toArray();
      unset($model['logs']);
      $logs[] = $model;
      // $logs['pessoa_alteracao_id'] = id_pessoa_logada;

      $unidade_gestora->logs = $logs;

      return $unidade_gestora;
    }
}