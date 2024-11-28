<?php
include_once "../../../configuracion.php";


$objControl = new AbmCompra();

$arreglo_salida = $objControl->listarPedidosVigentes();


echo json_encode($arreglo_salida);
