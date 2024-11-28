<?php
include_once ("../../configuracion.php");
$session = new Session();
$sessionIniciada = false;
$sessionValidada = $session->validar();
$headerSeguro = false;

if($sessionValidada){
    $sessionIniciada = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../lib/bootstrap-5.2.0-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="../lib/bootstrap-5.2.0-dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/login.js" defer></script>
    <script type="text/javascript" src="../js/registro.js" defer></script>
    <script src="../js/carrito.js" defer></script>

    <script src="../lib/md5.min.js"></script>
    <script src="../lib/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
    <script src="../lib/jquery.validate.min.js"></script>


    <link rel="stylesheet" href="../lib/DataTables-1.13.1/css/dataTables.bootstrap5.min.css">
    
    <script src="../lib/DataTables-1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="../lib/DataTables-1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <title><?php echo $titulo ?></title>
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
                        <a class="nav-link active" aria-current="page" href="../../index.php">Index</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Producto/listaProductos.php">Productos</a>
                    </li>

                    <?php
                        if($sessionIniciada){
                    ?>  
                            <li class="nav-item  ms-3 d-flex align-items-center justify-content-center">
                                <a data-bs-toggle="modal" href="../carrito/index.php" role="button" aria-controls="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="white" class="bi bi-cart3 text-dark" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="nav-item dropdown  ms-3 d-flex align-items-center justify-content-center">
                                <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-person-circle text-light" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    </svg>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../Perfil/index.php">Realizar Operaciones</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                              
                                    <li><a class="dropdown-item text-danger" href="../Perfil/accion/cerrarSesion.php">Cerrar Sesión</a></li>
                                </ul>
                            </li>
                    <?php
                        }else{
                    ?>
                            <li class="nav-item  ms-3 d-flex align-items-center justify-content-center">
                                <a data-bs-toggle="modal" href="#inicioSesion" role="button" aria-controls="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="white" class="bi bi-person-circle text-dark" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    </svg>
                                </a>
                            </li>
                    <?php
                        }
        
                    ?>
                </ul>
            </div>
        </div>
    </nav>

<?php
include_once "modalLogin.php";
?>