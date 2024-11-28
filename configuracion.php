<?php 

header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////


$PROYECTO ='PWD2024-TPFINAL';
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Util/funciones.php');
include_once($ROOT.'Util/funcionesMailer.php');
include 'vendor/phpmailer/phpmailer/src/Exception.php';
include 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
include 'vendor/phpmailer/phpmailer/src/SMTP.php';

$GLOBALS['ROOT']=$ROOT;

// Página de Autenticación
$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/login.php";

// Página Principal
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/home/index.php";

?>