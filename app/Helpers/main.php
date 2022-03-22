<?php

function formatDate($data, $exercicio=false) {
  $data = date_create($data);
  if($exercicio)
    return date_format($data,"Y");

  return date_format($data,"d/m/Y");
}

function dateToInput($data) {
  $data = date_create($data);
  return date_format($data,"Y-m-d");
}

function cnpj($cnpj) {

  if (! $cnpj) {
      return '';
  }
  if (strlen($cnpj) == 14) {
      return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
  }

  return $cnpj;
}
