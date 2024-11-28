<?php 
include_once "../../../configuracion.php";

// Que busque a todos los activos
$objControl = new AbmProducto();


echo json_encode($objControl->listarProductosActivos());
