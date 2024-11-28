<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;

$objC = new AbmProducto();

echo json_encode($objC->altaProducto($data));
?>