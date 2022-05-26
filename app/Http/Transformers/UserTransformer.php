<?php

namespace App\Http\Transformers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTransformer
{

    public static function toInstance(array $input, $user = null)
    {
      $logs = [];
      if (empty($user)) {
        $user = new User();
        $user->password = Hash::make($input['matricula']);
      } else {
          if($user->ativo == 1 && !isset($input['ativo']))
            $user->ativo = 0;
      }

      foreach ($input as $key => $value) {
        switch ($key) {
          case 'nome':
            $user->nome = $value;
            break;
          case 'cpf':
            $user->cpf = $value;
            break;
          case 'matricula':
            $user->matricula = $value;
            break;
          case 'password':
            if (Hash::check($value, $user->password))
            {
              $user->password = Hash::make($input['new_password']);
            } else {
              dd('bb');
            }
            break;
          case 'perfil':
            $user->perfil = $value;
            break;
            case 'ativo':
                $user->ativo = $value;
                break;
            case 'titulacao':
                $user->titulacao = $value;
                break;
        }
      }

      

      return $user;
    }
}