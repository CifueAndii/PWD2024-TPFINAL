<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new ControlCarrito();

echo json_encode($objControl->modificarCompraItem($data));
?>