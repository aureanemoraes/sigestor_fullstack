<?php

function formatDate($data) {
  $data = date_create($data);
  return date_format($data,"d/m/Y");
}

function dateToInput($data) {
  $data = date_create($data);
  return date_format($data,"Y-m-d");
}