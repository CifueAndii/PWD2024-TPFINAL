<?php
$titulo = "Producto";
include_once "../Estructura/headerInseguro.php";
//include_once "../../configuracion.php";

// Obtencion de datos y busqueda del producto
$param = data_submitted();
$objC = new AbmProducto;
$producto = $objC->buscar($param);

// Armado de destacados
$colecProductos = $objC->buscar(null);
unset($colecProductos[$producto[0]->getId()-1]); // Para evitar que aparezca el producto actual en la seccion "Le podria interesar"
//elijo 3 productos random para mostrar excepto el que quiero agregar al carrito
$destacados = array_rand($colecProductos, 3);
$recomendaciones = "";
//aca itero sobre $destacados que seria la seccion "Le podria interesar"
foreach ($destacados as $productoKey) {

    $recomendaciones .=
        '<div class="col-12 col-md-4 mb-3"><a class="text-dark text-decoration-none" href="../Producto/index.php?idproducto=' . $colecProductos[$productoKey]->getId() . '">
    <div class="card" style="width: 18rem;height:29rem">
        <img src="'.$colecProductos[$productoKey]->getImg().'" class="card-img-top" alt="' . $colecProductos[$productoKey]->getNombre() . '" style="width: 100%; height: 60%;">
        <div class="card-body">
            <p class="card-title">' . $colecProductos[$productoKey]->getNombre() . '</p>
            <p class="card-title"><b>' . $colecProductos[$productoKey]->getArtista() . '</b></p>
            <p class="card-title">' . $colecProductos[$productoKey]->getTipo() . '</p>
            <h4>$'.$colecProductos[$productoKey]->getPrecio().'</h4>
        </div>
    </div></a>
    </div>';
}

?>
<!-- Contenido -->
<div class="container my-5 mx-auto w-100 max">
    <div id="exito" class="container m-5 sticky-top"></div>
    <div id="erroresA"></div>
    <?php
    //verifico que $producto este definido y no sea nulo. 
    if (!isset($producto)) {
        echo mostrarError('El producto no fue encontrado.<br>
        <a href="../Home/index.php">Volver al menu principal</a>');
    } else {
        //si el usuario inicio sesion, se agrega al carrito, sino se abre el modal/popup de inicio de sesion
        $boton = ($sessionIniciada) ?
            '<button class="btn btn-primary col-12 my-2" type="submit" id="btn-submit2">Agregar al Carrito</button>' :
            '<button class="btn btn-primary col-12 my-2" data-bs-toggle="modal" href="#inicioSesion" role="button" aria-controls="modal">Agregar al Carrito</button>';

        echo '<div class="col-12 rounded">

        <div class="row col-12 p-3 rounded mx-auto">

            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center flex-column p-5">
                <img height = "400px" width = "300px" src="'. $producto[0]->getImg() .'" class="rounded img-fluid d-flex align-items-center justify-content-center" alt="Foto de perfil">
            </div> 

            <div class="col-12 col-md-6 p-5 d-flex align-items-center justify-content-center">

                <form method="POST" id="form-abm2">
                    <div class="col-12 bg-light p-5 rounded" >
                        <h5 class="fw-bold">' . $producto[0]->getNombre() . '</h5>
                        <h6 class="fw-bold">' . $producto[0]->getArtista() . '</h6>
                        <h7 class="fw-bold">' . $producto[0]->getTipo() . '</h7>
                        <h3 class="my-4">$<span id="precio">'.$producto[0]->getPrecio().'</span></h3>
                        <div class="row col-12 mb-2">
                            <input type="text" id="idproducto" name="idproducto" value="'. $producto[0]->getId() .'" hidden>
                            <div class="col-6 d-flex align-items-center justify-content-center">
                                Cantidad
                            </div>
                        
                            <div class="col-6">
                                <input type="number" class="form-control" value="1" name="cantidad" id="cantidad" min="0">
                                <div class="invalid-feedback" id="feedback-cantidad"></div>
                            </div>
                        </div>
                        

                        '.$boton.'
                    </div>

                </form>
                
            </div>
            <div class="col-12 rounded bg-light p-5 mb-5">
                <h4>Detalles del Producto</h4>
                ' . $producto[0]->getDetalle() . '
            </div>
            <h3 class="mb-4">Ver Más</h3>
            <div class="row col-12 mb-5 mx-auto">
            ' . $recomendaciones . '
            </div>
        </div>
    </div>';
    }
    ?>
</div>
<script src="../js/producto_sitio.js"></script>
<?php
include_once "../Estructura/footer.php";
?>