<?php

$titulo = "Todos los productos";
include_once("../estructura/header.php");

$ABMProductos = new AbmProducto();
$datos["prodeshabilitado"] = null;
$datos["protipo"] = "CD";
$listaProductos = convert_array($ABMProductos->buscar($datos));

?>

<!-- header de la seccion de todos los productos -->
<header style="margin-top: 100px; background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-8 fw-bolder">CDs</h1>
            <p class="lead fw-normal text-white-50 mb-0">
            <div class="bi bi-heart-fill"></div>
            </p>
        </div>
    </div>
</header>

<!-- generamos grilla de productos -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php 
            if (is_array($listaProductos) && count($listaProductos) > 0){

                foreach ($listaProductos as $producto){
                    ?>

                    <div class="col mb-5">
                        <div class="card h-100">
                            <div class="ratio ratio-1x1">                            
                                <img class="card-img-top mt-auto" src="<?php echo ($producto["proimg64"]); ?>" alt="<?php echo $producto["nombre"]?>">
                            </div>
                            <!-- card body -->
                            <div class="card-body mt-auto">
                                <div class="text-center">
                                    <h5 class="fw-bolder">
                                        <?php echo $producto["nombre"];?>
                                    </h5>
                                    <p class="text-secondary">
                                        <?php echo $producto["detalle"];?>
                                    </p>
                                    <p class="h5">
                                        <?php echo "$" . $producto["proprecio"]; ?>
                                    </p>
                                </div>
                            </div>
                            <!-- card footer -->
                             <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <?php 
                                if ($producto["cantStock"] < 1){
                                ?>
                                <div class="text-center">SIN STOCK</div>
                                <?php
                                } else{ ?>
                                <form action="../Action/cargarCarrito.php" method="post">
                                    <input type="hidden" name="idproducto" value="<?php echo $producto["id"];?>">
                                    <div class="text-center"><button class="btn btn-outline-dark mt-auto" type="submit">Agregar al carrito</button></div>
                                </form>
                                <?php
                                }
                                ?>
                             </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>

        </div>
    </div>
</section>




<?php include_once("../estructura/footer.php"); ?>