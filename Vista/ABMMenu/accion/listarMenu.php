<?php 
include_once "../../../configuracion.php";

$objControl = new AbmMenu();


echo json_encode($objControl->listarMenuActivo());
