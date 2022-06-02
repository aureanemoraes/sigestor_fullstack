<?php

use App\Models\User;

function formatDate($data, $exercicio=false) 
{
  $data = date_create($data);
  if($exercicio)
    return date_format($data,"Y");

  return date_format($data,"d/m/Y");
}

function dateToInput($data) 
{
  $data = date_create($data);
  return date_format($data,"Y-m-d");
}

function cnpj($cnpj) 
{
  if (! $cnpj) {
      return '';
  }
  if (strlen($cnpj) == 14) {
      return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
  }

  return $cnpj;
}

function formatCurrency($valor) 
{
  $valor = 'R$ ' . number_format($valor, 2, ',', '.');

  return $valor;
}

function formatMetaValue($dado, $tipo_dado)
{
  $dado = is_null($dado) || empty($dado) ? 0 : $dado;
  switch($tipo_dado) {
    case 'numeral':
      $dado_formatado = $dado;
      break;
    case 'porcentagem':
      $dado_formatado = $dado . '%';
      break;
    case 'moeda':
      $dado_formatado = formatCurrency($dado);
      break;
    default:
      $dado_formatado = $dado;
  }

  return $dado_formatado;
}

function slug($string)
{
  $slug = trim($string); // trim the string
  $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
  $slug= str_replace(' ','-', $slug); // replace spaces by dashes
  $slug= strtolower($slug);  // make it lowercase
  return $slug;
}

function userType($tipo) {
  switch($tipo) {
    case 'institucional':
      return User::whereHas('vinculos', function ($query) {
        $query->whereNotNull('instituicao_id');
      })->where('id', Auth::id())->exists();
      break;
    case 'gestor':
      return User::whereHas('vinculos', function ($query) {
        $query->whereNotNull('instituicao_id');
        $query->orWhereNotNull('unidade_gestora_id');
      })->where('id', Auth::id())->exists();
      break;
    case 'administrativo':
      return User::whereHas('vinculos', function ($query) {
        $query->whereNotNull('instituicao_id');
        $query->orWhereNotNull('unidade_administrativa_id');
      })->where('id', Auth::id())->exists();
      break;
    default:
      return false;
  }
  
}


