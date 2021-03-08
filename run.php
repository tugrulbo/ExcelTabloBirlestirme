<?php
require_once 'SimpleXLSX.php';
$operasyon = [];
$mola = [];
if ( $xlsx = SimpleXLSX::parse('giris.xlsx') ) {
  $operasyon=$xlsx->rows();
} else {
  echo SimpleXLSX::parseError();
}

if ( $xlsx = SimpleXLSX::parse('eklenti.xlsx') ) {
  $mola=$xlsx->rows();
} else {
  echo SimpleXLSX::parseError();
}

print_r($operasyon[1][2]);
?>