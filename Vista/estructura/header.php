<!DOCTYPE html>
<html lang="en">

<?php

include_once("../../configuracion.php");
$sesion = new Session();
$sesionActiva = $sesion->activa();

if ($sesionActiva) {
    $roles = $sesion->getRol();

    // delegamos a archivo de control
    // $controlCarritoCliente = new ControlCarritoCliente();
    // revisar si existe una compra en el carrito del cliente

}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- JQuery -->
    <script src="../js/jquery-3.7.1.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>

    <title><?php echo $titulo; ?></title>
</head>


<body class="d-flex flex-column">

    <!-- la navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- navbar brand comun a todos los roles -->
            <a class="navbar-brand" href="../home/index.php"><img src="../assets/esnupimusica.jpg" style="height: 75px;"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>

                    <?php 
                        $mostrarProductos = true;
                        if ($sesionActiva){
                            if ($roles <> null && is_array($roles)){
                            if ($roles[0] != 1 OR (count($roles) > 1 && $roles[1] != 1)){
                                $mostrarProductos = false;
                            } 
                        }
                        } 

                        if ($mostrarProductos){            
                    ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Productos
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">CDs</a></li>
                                    <li><a class="dropdown-item" href="#">DVDs</a></li>
                                    <li><a class="dropdown-item" href="#">Vinilos</a></li>
                                    <li><a class="dropdown-item" href="#">Todos los productos</a></li>
                                </ul>
                            </li>
                    <?php
                        }

                        // generar menú recorriendo los menues asociados a los roles
                        if ($sesionActiva){
                            foreach($roles as $rol){
                                $ABMMenuRol = new AbmMenuRol();
                                $listaMenuRol = $ABMMenuRol->buscar(['idrol' => $rol]);

                                if (is_array($listaMenuRol) && count($listaMenuRol) > 0){
                                    $ABMMenu = new AbmMenu();
                                    $idMenu = $listaMenuRol[0]->getObjMenu()->getId();
                                    $listaMenu = $ABMMenu->buscar(['id' => $idMenu]);

                                    if (is_array($listaMenu) && count($listaMenu) > 0){
                                        $idMenuAsociado = $listaMenu[0]->getId();
                                        $subMenuesAsociados = $ABMMenu->buscar(['idpadre' => $idMenuAsociado]);
                                    }
                                }

                                // incluimos menues en la navbar
                                foreach ($listaMenu as $menu){
                                    // verificamos que no fue deshabilitado
                                    if ($menu->getDeshabilitado() == '0000-00-00 00:00:00'){
                                        ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <?php echo $menu->getNombre();?>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                                    <?php
                                        foreach ($subMenuesAsociados as $submenu){
                                            if ($submenu->getDeshabilitado() == '0000-00-00 00:00:00'){
                                                switch ($rol){
                                                    case '1':
                                                        $prefijo = "../cliente/";
                                                        break;
                                                    case '2':
                                                        $prefijo = "../deposito/";
                                                        break;
                                                    case '3':
                                                        $prefijo = "../admin/";
                                                        break;
                                                }

                                                ?>

                                                 <li><a class="dropdown-item" href="<?php echo $prefijo . $submenu->getMedescripcion() . ".php"; ?>">
                                                    <?php echo $submenu->getNombre();?>
                                                 </a></li>
                                    <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }                         
                                    ?>
                </ul>
            </div>

            <!-- falta carrito de compras según rol -->

        </div>
    </nav>

</body>

</html>