<?php
$titulo = "Frecuencia Modulada";
include_once "../Estructura/headerInseguro.php";
?>
<!-- Contenido -->
<br><br><br><br>
<div id="carouselExampleIndicators" class="carousel mt-5 slide mx-auto shadow" data-bs-ride="carousel" style="max-width:1400px;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner  rounded-bottom">
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="../assets/discos.jpg" style="max-height: 500px" class="d-block w-100" alt="">
            <div class="carousel-caption d-none d-md-block" style="background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);">
                <h1>Frecuencia Modulada</h1>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="../assets/vinilos.png" style="max-height: 500px" class="d-block w-100" alt="">
            <div class="carousel-caption d-none d-md-block" style="background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);">
                <h1>Frecuencia Modulada</h1>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="../assets/cidis.png" style="max-height: 500px" class="d-block w-100" alt="">
            <div class="carousel-caption d-none d-md-block" style="background: rgb(255,255,255,255);
background: linear-gradient(360deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgb(33, 36, 41) 100%);">
                <h1>Frecuencia Modulada</h1>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php
include_once "../Producto/listaCD.php";
include_once "../Producto/listaDVD.php";
//include_once "../Producto/listaProductos.php";
include_once "../Producto/listaVinilos.php";
enviarMail(["id" => 4]);
?>

</head>

</html>

<?php
include_once "../Estructura/footer.php";
?>