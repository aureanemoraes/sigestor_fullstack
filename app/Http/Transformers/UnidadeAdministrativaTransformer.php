<?php

namespace App\Http\Transformers;

use App\Models\UnidadeAdministrativa;

class UnidadeAdministrativaTransformer
{

    public static function toInstance(array $input, $unidade_administrativa = null)
    {
      $logs = [];
      if (empty($unidade_administrativa)) {
        $unidade_administrativa = new UnidadeAdministrativa();
      } 

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $unidade_administrativa->nome = $value;
            break;
          case 'sigla':
            $unidade_administrativa->sigla = $value;
            break;
          case 'ugr':
            $unidade_administrativa->ugr = $value;
            break;
          case 'instituicao_id':
            $unidade_administrativa->instituicao_id = $value;
            break;
          case 'unidade_gestora_id':
            $unidade_administrativa->unidade_gestora_id = $value;
            break;
        }
      }

      if(isset($unidade_administrativa->logs)) {
        foreach($unidade_administrativa->logs as $log) {
          $logs[] = $log;
        } 
      }
      $model = $unidade_administrativa->toArray();
      unset($model['logs']);
      $logs[] = $model;
      // $logs['pessoa_alteracao_id'] = id_pessoa_logada;

      $unidade_administrativa->logs = $logs;

      return $unidade_administrativa;
    }
}