<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuario();

echo json_encode($objControl->modificarPerfil($data));
?>