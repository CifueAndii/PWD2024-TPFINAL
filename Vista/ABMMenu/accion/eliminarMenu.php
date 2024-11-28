<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC = new AbmMenu();


echo json_encode($objC->baja($data));
?>