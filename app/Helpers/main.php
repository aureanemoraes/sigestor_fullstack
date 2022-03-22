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