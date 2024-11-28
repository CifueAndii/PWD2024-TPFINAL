<?php 
include_once "../../../configuracion.php";

$objControl = new ControlCarrito();
$data = data_submitted();

echo json_encode($objControl->altaCompraItem($data));