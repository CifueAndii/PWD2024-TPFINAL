<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// recibe array con idcompra e idcet
function enviarMail ($data) {
    $user = buscarUsuario($data['id']);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;


        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = 'moduladaf@gmail.com';
        $mail->Password = 'jfotuwhmvidwvcfr';


        $mail->setFrom('moduladaf@gmail.com', 'Frecuencia Modulada');
        $mail->addAddress($user['usmail'], $user['usname']);

        $mail->isHTML(true);
        $mail->Subject = 'Estado de tu pedido';

        $mail->Body = armarBody($data);

        $mail->send();
        $exito = true;
    } catch (Exception $e) {
        $exito = false;
    }
    return $exito;
}

function buscarUsuario($idcompra){
    $objCompra = new abmCompra();
    $objC = $objCompra->buscar(['id' => $idcompra]);
   
    $objUsuario = $objC[0]->getObjUsuario();
    return (['usmail'=>$objUsuario->getMail(), 'usname'=>$objUsuario->getNombre()]);
}


function armarBody($data)
{
    switch ($data["idcompraestadotipo"]) {
        case 2:
            $htmlBody = '<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                        <html xmlns=“https://www.w3.org/1999/xhtml”>
                        <head>
                        <title>Test Email Sample</title>
                        <meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” />
                        <meta http–equiv=“X-UA-Compatible” content=“IE=edge” />
                        <meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
                        <style>
                        <!— CSS code (if any) —>
                           .bodyCont{
                                        
                                        width: 1200px; margin: 0 auto; height: 571px;
                                    }
                                    *{
                                        text-align: center;
                                    }
                                   
                                    .containerFull{
                                        margin-top: 25px;
                                        background-color: #F5EFE6;;
                                        
                                        border: solid 2px;
                                        padding: 0%;
                                        
                                    }
                                    .containerRedes{
                                        margin: 0 auto;
                                        width: 75%;
                                        margin-top: 1rem;
                                        border-top: solid 1px black;
                                    }
                                    
                                    .nav{
                                        width: 75%;
                                        height: 75px;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                        margin-top: 1.5rem;
background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);                                        padding: 1rem;  
                                        box-shadow: 5px 5px 15px 5px #000000;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
.h1{
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}
                                    .h3{
                                        font-size:25px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3.subtitle{
                                        font-size: 20px;
                                    }
                                    .h3.subtitleRedes{
                                        font-size: 20px;
                                        margin: 0 auto;
                                        margin-top: 1rem;
                                    }
                                    .h4{
                                        font-size:15px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    /*CSS BUTTON*/
                                    .hvr-overline-from-center {
                                        margin-top: 1rem;
                                        background-color: #BFACE2;
                                        border-color: transparent;
                                        border-radius: 10px;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        display: inline-block;
                                        width: 150px;
                                        height: 45px;margin-bottom: 2rem;
                                        vertical-align: middle;
                                        -webkit-transform: perspective(1px) translateZ(0);
                                        transform: perspective(1px) translateZ(0);
                                        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                        position: relative;
                                        overflow: hidden;
                                        }
                                        .hvr-overline-from-center:before {
                                        content: "";
                                        position: absolute;
                                        z-index: -1;
                                        left: 51%;
                                        right: 51%;
                                        top: 0;
                                        background: rgb(28, 199, 148);
                                        height: 4px;
                                        -webkit-transition-property: left, right;
                                        transition-property: left, right;
                                        -webkit-transition-duration: 0.3s;
                                        transition-duration: 0.3s;
                                        -webkit-transition-timing-function: ease-out;
                                        transition-timing-function: ease-out;
                                        }
                                        .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                        left: 0;
                                        right: 0;
                                        }
                                    /*CSS BUTTON*/
                                    
                                    .namebrand *{
                                        color:#F5EFE6;
                                        padding: 5px;
                                    }
                        </style>

                        
                                </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class="bodyCont">
                    <div class="containerFull">
                        <div class="nav">
                            <div class="namebrand">
                                <h2><i class="fa-solid fa-seedling"></i>Frecuencia Modulada<i class="fa-solid fa-seedling"></i></h2>
                            </div>
                            
                        </div>
                        <div class="containerText"><h1 class="h1">Pago confirmado</h1>
                            <h3 class=2h3">Hemos confirmado tu pago</h3>
                            <h3 class="h3 subtitle">El ID para seguir tu compra es:' . $data['id'] . '</h3>

                            <h3 class="h3 subtitle">La preparación de los pedidos puede tomar hasta 48hs hábiles.</h3>
                            <br/>
                            
                            <h4 class="h4">Te informaremos por este medio cuando el envío haya sido armado y despachado</h3>
                            </div>
                            <div class="containerRedes">
                                <h3 class="h3 subtitleRedes">Estado de tu compra!</h3>
                                <a  href="http://localhost/index.php/Vista/Pedidos/index.php" target="_blank"><button class="hvr-overline-from-center" >Click aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>
 

                        </head>';
            break;
        case 3:
            $htmlBody = '<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                        <html xmlns=“https://www.w3.org/1999/xhtml”>
                        <head>
                        <title>Test Email Sample</title>
                        <meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” />
                        <meta http–equiv=“X-UA-Compatible” content=“IE=edge” />
                        <meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
                        <style>
                        <!— CSS code (if any) —>
                           .bodyCont{
                                        
                                        width: 1200px; margin: 0 auto; height: 571px;
                                    }
                                    *{
                                        text-align: center;
                                    }
                                   
                                    .containerFull{
                                        margin-top: 25px;
                                        background-color: #F5EFE6;;
                                        
                                        border: solid 2px;
                                        padding: 0%;
                                        
                                    }
                                    .containerRedes{
                                        margin: 0 auto;
                                        width: 75%;
                                        margin-top: 1rem;
                                        border-top: solid 1px black;
                                    }
                                    
                                    .nav{
                                        width: 75%;
                                        height: 75px;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                        margin-top: 1.5rem;
background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);                                        padding: 1rem;  
                                        box-shadow: 5px 5px 15px 5px #000000;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
.h1{
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}
                                    .h3{
                                        font-size:25px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    .h3.subtitle{
                                        font-size: 20px;
                                    }
                                    .h3.subtitleRedes{
                                        font-size: 20px;
                                        margin: 0 auto;
                                        margin-top: 1rem;
                                    }
                                    .h4{
                                        font-size:15px;
                                        font-weight:normal;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                    }
                                    /*CSS BUTTON*/
                                    .hvr-overline-from-center {
                                        margin-top: 1rem;
                                        background-color: #BFACE2;
                                        border-color: transparent;
                                        border-radius: 10px;
                                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        display: inline-block;
                                        width: 150px;
                                        height: 45px;margin-bottom: 2rem;
                                        vertical-align: middle;
                                        -webkit-transform: perspective(1px) translateZ(0);
                                        transform: perspective(1px) translateZ(0);
                                        box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                        position: relative;
                                        overflow: hidden;
                                        }
                                        .hvr-overline-from-center:before {
                                        content: "";
                                        position: absolute;
                                        z-index: -1;
                                        left: 51%;
                                        right: 51%;
                                        top: 0;
                                        background: rgb(28, 199, 148);
                                        height: 4px;
                                        -webkit-transition-property: left, right;
                                        transition-property: left, right;
                                        -webkit-transition-duration: 0.3s;
                                        transition-duration: 0.3s;
                                        -webkit-transition-timing-function: ease-out;
                                        transition-timing-function: ease-out;
                                        }
                                        .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                        left: 0;
                                        right: 0;
                                        }
                                    /*CSS BUTTON*/
                                    
                                    .namebrand *{
                                        color:#F5EFE6;
                                        padding: 5px;
                                    }
                        </style>

                        
                                </style>
                    <title>Mail Confirm</title>
                </head>
            
                <body class="bodyCont">
                    <div class="containerFull">
                        <div class="nav">
                            <div class="namebrand">
                                <h2><i class="fa-solid fa-seedling"></i>Frecuencia Modulada<i class="fa-solid fa-seedling"></i></h2>
                            </div>
                            
                        </div>
                        <div class="containerText"><h1 class="h1">Tu compra ha sido aceptada</h1>
                            <h3 class=2h3">Tu pedido ha sido preparado y está listo para despachar</h3>
                            <h3 class="h3 subtitle">El ID para seguir tu compra es:' . $data['id'] . '</h3>
                            <h3 class="h3 subtitle">El envío de los pedidos puede tomar hasta 48hs hábiles.</h3>
                            <br/>
                            
                            <h4 class="h4">Te informaremos por este medio cuando el envío haya despachado</h3>
                            </div>
                            <div class="containerRedes">
                                <h3 class="h3 subtitleRedes">Estado de tu compra!</h3>
                                <a  href="http://localhost/PWD2024-TPFINAL/Vista/Pedidos/index.php" target="_blank"><button class="hvr-overline-from-center" >Click aquí!</button></a>
                            </div>
                        </div>
                    </body>
                </html>
 

                        </head>';
            break;
        case 4:
            $htmlBody = '<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                            <html xmlns=“https://www.w3.org/1999/xhtml”>
                            <head>
                            <title>Test Email Sample</title>
                            <meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” />
                            <meta http–equiv=“X-UA-Compatible” content=“IE=edge” />
                            <meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
                            <style>
                            <!— CSS code (if any) —>
                               .bodyCont{
                                            
                                            width: 1200px; margin: 0 auto; height: 571px;
                                        }
                                        *{
                                            text-align: center;
                                        }
                                       
                                        .containerFull{
                                            margin-top: 25px;
                                            background-color: #F5EFE6;;
                                            
                                            border: solid 2px;
                                            padding: 0%;
                                            
                                        }
                                        .containerRedes{
                                            margin: 0 auto;
                                            width: 75%;
                                            margin-top: 1rem;
                                            border-top: solid 1px black;
                                        }
                                        
                                        .nav{
                                            width: 75%;
                                            height: 75px;
                                            border-radius: 5px;
                                            margin: 0 auto;
                                            margin-top: 1.5rem;
    background: rgb(255,255,255,255);
    background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);                                        padding: 1rem;  
                                            box-shadow: 5px 5px 15px 5px #000000;
                                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        }
    .h1{
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
                                        .h3{
                                            font-size:25px;
                                            font-weight:normal;
                                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        }
                                        .h3.subtitle{
                                            font-size: 20px;
                                        }
                                        .h3.subtitleRedes{
                                            font-size: 20px;
                                            margin: 0 auto;
                                            margin-top: 1rem;
                                        }
                                        .h4{
                                            font-size:15px;
                                            font-weight:normal;
                                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                                        }
                                        /*CSS BUTTON*/
                                        .hvr-overline-from-center {
                                            margin-top: 1rem;
                                            background-color: #BFACE2;
                                            border-color: transparent;
                                            border-radius: 10px;
                                            font-family: Verdana, Geneva, Tahoma, sans-serif;
                                            display: inline-block;
                                            width: 150px;
                                            height: 45px;margin-bottom: 2rem;
                                            vertical-align: middle;
                                            -webkit-transform: perspective(1px) translateZ(0);
                                            transform: perspective(1px) translateZ(0);
                                            box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                            position: relative;
                                            overflow: hidden;
                                            }
                                            .hvr-overline-from-center:before {
                                            content: "";
                                            position: absolute;
                                            z-index: -1;
                                            left: 51%;
                                            right: 51%;
                                            top: 0;
                                            background: rgb(28, 199, 148);
                                            height: 4px;
                                            -webkit-transition-property: left, right;
                                            transition-property: left, right;
                                            -webkit-transition-duration: 0.3s;
                                            transition-duration: 0.3s;
                                            -webkit-transition-timing-function: ease-out;
                                            transition-timing-function: ease-out;
                                            }
                                            .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                            left: 0;
                                            right: 0;
                                            }
                                        /*CSS BUTTON*/
                                        
                                        .namebrand *{
                                            color:#F5EFE6;
                                            padding: 5px;
                                        }
                            </style>
    
                            
                                    </style>
                        <title>Mail Confirm</title>
                    </head>
                
                    <body class="bodyCont">
                        <div class="containerFull">
                            <div class="nav">
                                <div class="namebrand">
                                    <h2><i class="fa-solid fa-seedling"></i>Frecuencia Modulada<i class="fa-solid fa-seedling"></i></h2>
                                </div>
                                
                            </div>
                            <div class="containerText"><h1 class="h1">Tu pedido ha sido enviado!</h1>
                                <h3 class=2h3">Hemos despachado tu pedido</h3>
                                <h3 class="h3 subtitle">El ID de tu compra es:' . $data['id'] . '</h3>
                                <h3 class="h3 subtitle">Gracias por comprar en Frecuencia Modulada!</h3>
                                </div>
                                <div class="containerRedes">
                                    <h3 class="h3 subtitleRedes">Estado de tu compra</h3>
                                    <a  href="http://localhost/index.php/Vista/Pedidos/index.php" target="_blank"><button class="hvr-overline-from-center" >Click aquí!</button></a>
                                </div>
                            </div>
                        </body>
                    </html>
     
    
                            </head>';
            break;
        case 5:
            $htmlBody = '<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                                <html xmlns=“https://www.w3.org/1999/xhtml”>
                                <head>
                                <title>Test Email Sample</title>
                                <meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” />
                                <meta http–equiv=“X-UA-Compatible” content=“IE=edge” />
                                <meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
                                <style>
                                <!— CSS code (if any) —>
                                   .bodyCont{
                                                
                                                width: 1200px; margin: 0 auto; height: 571px;
                                            }
                                            *{
                                                text-align: center;
                                            }
                                           
                                            .containerFull{
                                                margin-top: 25px;
                                                background-color: #F5EFE6;;
                                                
                                                border: solid 2px;
                                                padding: 0%;
                                                
                                            }
                                            .containerRedes{
                                                margin: 0 auto;
                                                width: 75%;
                                                margin-top: 1rem;
                                                border-top: solid 1px black;
                                            }
                                            
                                            .nav{
                                                width: 75%;
                                                height: 75px;
                                                border-radius: 5px;
                                                margin: 0 auto;
                                                margin-top: 1.5rem;
        background: rgb(255,255,255,255);
        background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);                                        padding: 1rem;  
                                                box-shadow: 5px 5px 15px 5px #000000;
                                                font-family: Verdana, Geneva, Tahoma, sans-serif;
                                            }
        .h1{
          font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
                                            .h3{
                                                font-size:25px;
                                                font-weight:normal;
                                                font-family: Verdana, Geneva, Tahoma, sans-serif;
                                            }
                                            .h3.subtitle{
                                                font-size: 20px;
                                            }
                                            .h3.subtitleRedes{
                                                font-size: 20px;
                                                margin: 0 auto;
                                                margin-top: 1rem;
                                            }
                                            .h4{
                                                font-size:15px;
                                                font-weight:normal;
                                                font-family: Verdana, Geneva, Tahoma, sans-serif;
                                            }
                                            /*CSS BUTTON*/
                                            .hvr-overline-from-center {
                                                margin-top: 1rem;
                                                background-color: #BFACE2;
                                                border-color: transparent;
                                                border-radius: 10px;
                                                font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                display: inline-block;
                                                width: 150px;
                                                height: 45px;margin-bottom: 2rem;
                                                vertical-align: middle;
                                                -webkit-transform: perspective(1px) translateZ(0);
                                                transform: perspective(1px) translateZ(0);
                                                box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                                position: relative;
                                                overflow: hidden;
                                                }
                                                .hvr-overline-from-center:before {
                                                content: "";
                                                position: absolute;
                                                z-index: -1;
                                                left: 51%;
                                                right: 51%;
                                                top: 0;
                                                background: rgb(28, 199, 148);
                                                height: 4px;
                                                -webkit-transition-property: left, right;
                                                transition-property: left, right;
                                                -webkit-transition-duration: 0.3s;
                                                transition-duration: 0.3s;
                                                -webkit-transition-timing-function: ease-out;
                                                transition-timing-function: ease-out;
                                                }
                                                .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                                left: 0;
                                                right: 0;
                                                }
                                            /*CSS BUTTON*/
                                            
                                            .namebrand *{
                                                color:#F5EFE6;
                                                padding: 5px;
                                            }
                                </style>
        
                                
                                        </style>
                            <title>Mail Confirm</title>
                        </head>
                    
                        <body class="bodyCont">
                            <div class="containerFull">
                                <div class="nav">
                                    <div class="namebrand">
                                        <h2><i class="fa-solid fa-seedling"></i>Frecuencia Modulada<i class="fa-solid fa-seedling"></i></h2>
                                    </div>
                                    
                                </div>
                                <div class="containerText"><h1 class="h1">Tu compra ha sido aceptada</h1>
                                    <h3 class=2h3">Tu pedido ha sido preparado y está listo para despachar</h3>
                                    <h3 class="h3 subtitle">El ID para seguir tu compra es:' . $data['id'] . '</h3>
                                    <h3 class="h3 subtitle">El envío de los pedidos puede tomar hasta 48hs hábiles.</h3>
                                    <br/>
                                    
                                    <h4 class="h4">Te informaremos por este medio cuando el envío haya despachado</h3>
                                    </div>
                                    <div class="containerRedes">
                                        <h3 class="h3 subtitleRedes">Estado de tu compra!</h3>
                                        <a  href="http://localhost/index.php/Vista/Pedidos/index.php" target="_blank"><button class="hvr-overline-from-center" >Click aquí!</button></a>
                                    </div>
                                </div>
                            </body>
                        </html>
         
        
                                </head>';
            break;
        case 4:
            $htmlBody = '<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                                    <html xmlns=“https://www.w3.org/1999/xhtml”>
                                    <head>
                                    <title>Test Email Sample</title>
                                    <meta http–equiv=“Content-Type” content=“text/html; charset=UTF-8” />
                                    <meta http–equiv=“X-UA-Compatible” content=“IE=edge” />
                                    <meta name=“viewport” content=“width=device-width, initial-scale=1.0 “ />
                                    <style>
                                    <!— CSS code (if any) —>
                                       .bodyCont{
                                                    
                                                    width: 1200px; margin: 0 auto; height: 571px;
                                                }
                                                *{
                                                    text-align: center;
                                                }
                                               
                                                .containerFull{
                                                    margin-top: 25px;
                                                    background-color: #F5EFE6;;
                                                    
                                                    border: solid 2px;
                                                    padding: 0%;
                                                    
                                                }
                                                .containerRedes{
                                                    margin: 0 auto;
                                                    width: 75%;
                                                    margin-top: 1rem;
                                                    border-top: solid 1px black;
                                                }
                                                
                                                .nav{
                                                    width: 75%;
                                                    height: 75px;
                                                    border-radius: 5px;
                                                    margin: 0 auto;
                                                    margin-top: 1.5rem;
            background: rgb(255,255,255,255);
            background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);                                        padding: 1rem;  
                                                    box-shadow: 5px 5px 15px 5px #000000;
                                                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                }
            .h1{
              font-family: Verdana, Geneva, Tahoma, sans-serif;
            }
                                                .h3{
                                                    font-size:25px;
                                                    font-weight:normal;
                                                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                }
                                                .h3.subtitle{
                                                    font-size: 20px;
                                                }
                                                .h3.subtitleRedes{
                                                    font-size: 20px;
                                                    margin: 0 auto;
                                                    margin-top: 1rem;
                                                }
                                                .h4{
                                                    font-size:15px;
                                                    font-weight:normal;
                                                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                }
                                                /*CSS BUTTON*/
                                                .hvr-overline-from-center {
                                                    margin-top: 1rem;
                                                    background-color: #BFACE2;
                                                    border-color: transparent;
                                                    border-radius: 10px;
                                                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                                                    display: inline-block;
                                                    width: 150px;
                                                    height: 45px;margin-bottom: 2rem;
                                                    vertical-align: middle;
                                                    -webkit-transform: perspective(1px) translateZ(0);
                                                    transform: perspective(1px) translateZ(0);
                                                    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
                                                    position: relative;
                                                    overflow: hidden;
                                                    }
                                                    .hvr-overline-from-center:before {
                                                    content: "";
                                                    position: absolute;
                                                    z-index: -1;
                                                    left: 51%;
                                                    right: 51%;
                                                    top: 0;
                                                    background: rgb(28, 199, 148);
                                                    height: 4px;
                                                    -webkit-transition-property: left, right;
                                                    transition-property: left, right;
                                                    -webkit-transition-duration: 0.3s;
                                                    transition-duration: 0.3s;
                                                    -webkit-transition-timing-function: ease-out;
                                                    transition-timing-function: ease-out;
                                                    }
                                                    .hvr-overline-from-center:hover:before, .hvr-overline-from-center:focus:before, .hvr-overline-from-center:active:before {
                                                    left: 0;
                                                    right: 0;
                                                    }
                                                /*CSS BUTTON*/
                                                
                                                .namebrand *{
                                                    color:#F5EFE6;
                                                    padding: 5px;
                                                }
                                    </style>
            
                                    
                                            </style>
                                <title>Mail Confirm</title>
                            </head>
                        
                            <body class="bodyCont">
                                <div class="containerFull">
                                    <div class="nav">
                                        <div class="namebrand">
                                            <h2><i class="fa-solid fa-seedling"></i>Frecuencia Modulada<i class="fa-solid fa-seedling"></i></h2>
                                        </div>
                                        
                                    </div>
                                    <div class="containerText"><h1 class="h1">Tu compra ha sido cancelada</h1>
                                        <h3 class=2h3">Hemos cancelado tu pedido desde nuestro sistema</h3>
                                        <h3 class="h3 subtitle">El ID del compra es:' . $data['id'] . '</h3>
                                        <h3 class="h3 subtitle">Ante cualquier consulta, no dude en comunicarse con nosotros respondiendo este mail.</h3>
                                        </div>
                                        <div class="containerRedes">
                                            <h3 class="h3 subtitleRedes">Estado de tu compra</h3>
                                            <a  href="http://localhost/index.php/Vista/Pedidos/index.php" target="_blank"><button class="hvr-overline-from-center" >Click aquí!</button></a>
                                        </div>
                                    </div>
                                </body>
                            </html>
             
            
                                    </head>';
            break;
    }

    return $htmlBody;
}

