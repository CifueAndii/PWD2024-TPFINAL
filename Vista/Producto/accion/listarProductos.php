<?php

include_once("../../../configuracion.php");

$data = data_submitted();
$ABMProducto = new AbmProducto();

echo json_encode(convert_array($ABMProducto->buscar($data)));

?>