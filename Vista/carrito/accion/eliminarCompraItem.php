<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC = new AbmCompra();

echo json_encode($objC->eliminarItem($data));
?>