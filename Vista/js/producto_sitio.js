var url;
const PRECIO = $("#precio").text();


/**
 * Plantilla para mostrar un cartel de error
 * @param string $contenidoError
 * @return string
 */
function mostrarError(contenidoError) {
    return (
        '<div class="col-12 alert alert-danger m-3 p-3 mx-auto alert-dismissible fade show" role="alert">' +
        contenidoError +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    );
}
$("#form-abm2").validate({
    rules: {
        cantidad: {
            required: true,
        },
    },
    messages: {
        cantidad: {
            required: "Obligatorio",
            min: "Debe ser mayor a 0",
            number: "Ingrese un número válido"
        },
    },
    errorPlacement: function(error, element) {
        let id = "#feedback-" + element.attr("id");
        element.addClass("is-invalid");

        $(id).text(error[0].innerText);
    },
    highlight: function(element) {
        $(element).removeClass("is-valid").addClass("is-invalid");
    },
    unhighlight: function(element) {
        $(element).removeClass("is-invalid").addClass("is-valid");
    },
    success: function(element) {
        $(element).addClass("is-valid");
    },
    submitHandler: function(e) {
        //agregue validacion para que si la cantidad es cero no lo agregue al carrito
        
        var cantidad = parseInt($("#cantidad").val());
        if (cantidad <= 0) {
            $("#erroresA").html(mostrarError("La cantidad debe ser mayor a cero."));
            return false; // Detiene el envío del formulario
    }
        $.ajax({
        
            url: "../carrito/accion/altaCompraItem.php",
            type: "POST",
            data: $("#form-abm2").serialize(),
            beforeSend: function() {
                $("#btn-submit2").html(
                    '<span class="spinner-border spinner-border-sm mx-2" role="status" aria-hidden="true"></span>Cargando...'
                );
            },
            complete: function() {
                $("#btn-submit2").html("Agregar al Carrito");
            },
            success: function(result) {
                result = JSON.parse(result);

                if (result.respuesta) {
                    var exito = '<div class=col-12 alert alert-success m-5 p-5 mx-auto alert-dismissible fade show position-sticky" role="alert">Se agregó con éxito<br>'+
                    '<a href="../carrito/index.php">Ver en su carrito.</a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $("#exito").html(exito);
                } else {
                    $("#erroresA").html(mostrarError(result.errorMsg));
                }
            },
        });
    },
});

$("#cantidad").on("input",function(){
    $("#precio").text($("#cantidad").val() * PRECIO);
})

function recargar() {
    $("#tabla").DataTable().ajax.reload();
}

function limpiar() {
    $("#form-abm").trigger("reset");
    $("#roldescripcion").removeClass("is-invalid").removeClass("is-valid");
    $("#permisos").removeClass("is-invalid").removeClass("is-valid");
    var arreglo = $(".permisos");
    for (var i = 0; i < arreglo.length; i++) {
        arreglo[i].removeAttribute("checked");
    }
}

function newMenu() {
    $("#title").html("Nuevo");
    $("#dlg").modal("show");

    limpiar();

    $("#btn-submit2").html("Agregar");
    $("#btn-submit2").removeClass("btn-danger").addClass("btn-primary");

    url = "accion/altaRol.php";
}

function editMenu() {
    $("#tabla tbody").on("click", "button", function() {
        var data = $("#tabla").DataTable().row($(this).parents("tr")).data();

        if (data != null) {
            $("#title").html("Editar");
            $("#dlg").modal("show");
            limpiar();

            var arreglo = $(".permisos");
            for (var i = 0; i < arreglo.length; i++) {
                if ($("#" + data["id"] + "-" + arreglo[i].value).length != 0) {
                    arreglo[i].setAttribute("checked", "true");
                }
            }

            $("#btn-submit2").html("Editar");
            $("#btn-submit2").removeClass("btn-danger").addClass("btn-primary");

            $("#id").val(data["id"]);
            $("#roldescripcion").val(data["roldescripcion"]);

            url = "accion/modificarRol.php";
        }
    });
}