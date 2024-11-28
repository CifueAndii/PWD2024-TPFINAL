<?php
include_once "../../../configuracion.php";

$data = data_submitted();

$objControl = new AbmCompra;

echo json_encode($objControl->cancelarCompra(["id" => $data["id"],"idcompraestadotipo" => 5]));

?>