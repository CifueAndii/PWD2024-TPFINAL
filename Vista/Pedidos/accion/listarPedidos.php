<?php 
include_once "../../../configuracion.php";


$objControl = new AbmCompra();

$session = new Session();

$param["idusuario"] = $session->getUsuario()->getId();


echo json_encode($objControl->listarPedidosUsuario($param));
