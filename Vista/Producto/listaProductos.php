<?php

$titulo = "Todos los productos";
include_once("../Estructura/headerInseguro.php");

// $ABMProductos = new AbmProducto();
// $datos["prodeshabilitado"] = null;
// $listaProductos = convert_array($ABMProductos->buscar($datos));

?>

<!-- header de la seccion de todos los productos -->
<header style="margin-top: 100px; background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-8 fw-bolder">Todos los productos</h1>
            <p class="lead fw-normal text-white-50 mb-0">
            <div class="bi bi-heart-fill"></div>
            </p>
        </div>
    </div>
</header>

<!-- grilla de productos -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div id="contenedorProductos" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            

        </div>
    </div>
</section>

<script>
// que todo se ejecute apenas carga el dom
$(window).on("load", function(){

    $.ajax({
        method: "POST",
        url: "./accion/listarProductos.php",
        data: null,
        success: function (response){
            // refresh productos
            $('#contenedorProductos').empty();

            // restauro arreglo q viene de listarproductos
            var productos = $.parseJSON(response);


            if ((productos.length) > 0){
            // recorro el arreglo de todos los productos y genero las cards
            $.each(productos, function(index, producto){
                console.log(producto);

                if (producto["prodeshabilitado"] == null){
                $('#contenedorProductos').append('<div class="col mb-5"><div class="card h-100"><div class="ratio ratio-1x1"><img class="card-img-top mt-auto" src="' + producto.proimg + '" alt="' + producto["nombre"] + '"></div><div class="card-body mt-auto"><div class="text-center"><h5 class="fw-bolder">' + producto["nombre"] + '</h5><h6>' + producto["proartista"] + '</h6><p class="text-secondary">'+ producto["detalle"] +'</p><p class=h5>'+ producto["proprecio"] +'</p><div class="card-footer p-4 py-2 mt-3 border-top-0 bg-transparent"></div></div></div></div></div>');
                    if (producto["cantStock"] > 0){
                        // boton de agregar al carrito
                        agregarAlCarrito = '<form action="./index.php" method="post"><input type="hidden" name="idproducto" value="'+producto.id+'"><div class="text-center"><button class="btn btn-outline-dark mt-auto" type="submit">Agregar al carrito</button></div></form>';
                    } else 
                    // si no hay stock muestro mensajito
                    agregarAlCarrito = '<div class="text-center">SIN STOCK</div>';
                }                          
                                
            }
            );
            // agrego contenido al card footer
            $('#contenedorProductos .card-footer').append(agregarAlCarrito);

            } else $('#contenedorProductos').append('<h1>Todavía no hay productos cargados</h1>');        
        }
    })
});
</script>


<?php include_once("../estructura/footer.php"); ?>