<?php

$objC = new AbmUsuario();
$arreglo = $objC->buscar(["id" => $session->getUsuario()->getId()]);

$objR = new AbmRol();
$menu = "";

// buscar roles del usuario
$arregloRoles = $objC->buscarRoles(["id" => $session->getUsuario()->getId()]);

// armar arreglo de opciones de menu
$nuevo = array();

foreach ($arregloRoles as $rol) {
    $permisos = $objR->buscarPermisos(["id" => $rol->getObjRol()->getId()]);

    if ($permisos != null) {
        $menu .= "<h5>Usuario: " . $rol->getObjRol()->getRolDescripcion() . "</h5><hr>";
        // mostrar
        foreach ($permisos as $permiso) {
            if($permiso->getObjMenu()->getDescripcion() != "../Perfil/index.php" && $permiso->getObjMenu()->getDescripcion() != "../pago/index.php"){
                $menu .= '
                    <div class="col-12 mb-2">
                        <a href="' . $permiso->getObjMenu()->getDescripcion() . '" class="btn text-success"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="bi bi-caret-right-fill mb-1" viewBox="0 0 16 16">
                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                        </svg>
                            <h4 class="d-inline mx-3">' . $permiso->getObjMenu()->getNombre() . '</h4>
                        </a>
                    </div>';
            }
        }
    }
}
?> 

<div class="offcanvas offcanvas-end" tabindex="-1" id="menu-dinamico" aria-labelledby="menu-dinamico-label">
    <div class="offcanvas-header">
        <h1 class="offcanvas-title text-center fw-5" id="menu-dinamico-label"><img src="../assets/discos.jpg" class="col-10 img-fluid" alt=""></h1>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h4>¡Bienvenid@ <?php echo $arreglo[0]->getNombre() ?>!</h4>
        <hr>
        <?php echo $menu; ?>
        <hr>
        <div class="col-12 mb-1 mx-2">
            <a href="../perfil/accion/cerrarSesion.php" class="text-decoration-none text-danger">Cerrar Sesión</a>
        </div>
    </div>
</div>
</div>
