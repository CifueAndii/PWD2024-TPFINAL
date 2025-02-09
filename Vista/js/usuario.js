var url;

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
//se ejecuta cuando el DOM se cargo, se inicializa datatable y se agregan validaciones con jquery validator
$(document).ready(function() {
    var table = $("#tabla").DataTable({
        responsive: true,
        ajax: {
            url: "../ABMUsuario/accion/listarUsuario.php",
            dataSrc: "",
        },
        columns: [{
                data: "id",
            },
            {
                data: "nombre",
            },
            {
                data: "mail",
            },
            {
                data: "roles",
            },
            {
                data: "accion",
            },
        ],
    });

    $(document).on('click', '#botonRecarga', function(){
        table.ajax.reload();
    });



// aca personalizo la validacion del email agregandosela al plugin JQuery Validate
    $.validator.addMethod(
        "customEmailValidation",
        function(value, element) {
            // Devuelve true si el correo electrónico es válido, y false si no lo es
            var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return this.optional(element) || pattern.test(value);
        },
        "Ingrese un correo electrónico válido"
    );    
//agrego el metodo diferentes al jquery validate
    $.validator.addMethod(
        "diferentes",
        function() {
            resp = false;

            if ($("#nombre").val() != $("#pass").val()) {
                resp = true;
            }

            return resp;
        },
        "El usuario y la contraseña no pueden ser iguales."
    );

    $.validator.addMethod(
        "formatoPass",
        function(value) {
            return /^(?=.*\d).{8,16}$/.test(value);
        },
        "La contraseña debe incluir entre 8 y 16 caracteres y al menos un número."
    );
});

//aca se aplican las reglas de validacion definidas previamente en el form 

$("#form-abm").validate({
    rules: {
        nombre: {
            required: true,
        },
        mail: {
            required: true,
            customEmailValidation: true,
        },
        pass: {
            required: true,
        },
    },
    messages: {
        nombre: {
            required: "Obligatorio",
        },
        mail: {
            required: "Obligatorio",
            customEmailValidation: "Debe ingresar un correo electrónico válido",
        },
        pass: {
            required: "Obligatorio",
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

    //aca se utiliza el plugin JQuery validate para hacer la validacion del form
    //especificamos reglas de validacion y msjs de error 
    // ""  ""      como se manejan msjs de error y exito

    submitHandler: function(e) {
        if ($("#pass").val() != null && $("#pass").val() != "") {
            $("#pass").val(md5($("#pass").val()));
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $("#form-abm").serialize(),
            beforeSend: function() {
                $("#btn-submit").html(
                    '<span class="spinner-border spinner-border-sm mx-2" role="status" aria-hidden="true"></span>Cargando...'
                );
            },
            complete: function() {
                $("#btn-submit").html("Reintentar");
            },
            success: function(result) {
                result = JSON.parse(result);

                if (result.respuesta) {
                    $("#dlg").modal("hide");
                    $("#form-abm").trigger("reset");
                    recargar();
                } else {
                    $("#errores").html(mostrarError(result.errorMsg));
                    $("#pass").val("");
                }
            },
        });
    },
});

//aca agrego reglas adicionales a los campos pass y nombre (estan definidas mas arriba)
$("#pass").rules("add", {
    formatoPass: true,
    diferentes: true,
});
$("#nombre").rules("add", {
    diferentes: true,
});


function limpiar() {
    $("#form-abm").trigger("reset");
    $("#nombre").removeClass("is-invalid").removeClass("is-valid");
    $("#mail").removeClass("is-invalid").removeClass("is-valid");
    $("#pass").removeClass("is-invalid").removeClass("is-valid");
    var arreglo = $(".roles");
    for (var i = 0; i < arreglo.length; i++) {
        arreglo[i].removeAttribute("checked");
    }
}

function newMenu() {
    $("#title").html("Nuevo");
    $("#dlg").modal("show");

    limpiar();

    $("#password-field").show();
    $("#delete-form").hide();
    $("#edit-form").show();

    $("#btn-submit").html("Agregar");
    $("#btn-submit").removeClass("btn-danger").addClass("btn-primary");

    url = "accion/altaUsuario.php";
}

function editMenu() {
    $("#tabla tbody").on("click", "button", function() {
        var data = $("#tabla").DataTable().row($(this).parents("tr")).data();

        if (data != null) {
            $("#title").html("Editar");
            $("#dlg").modal("show");
            limpiar();

            var arreglo = $(".roles");
            for (var i = 0; i < arreglo.length; i++) {
                if ($("#" + data["id"] + "-" + arreglo[i].value).length != 0) {
                    arreglo[i].setAttribute("checked", "true");
                }
            }

            $("#password-field").hide();
            $("#delete-form").hide();
            $("#edit-form").show();

            $("#btn-submit").html("Editar");
            $("#btn-submit").removeClass("btn-danger").addClass("btn-primary");

            $("#id").val(data["id"]);
            $("#nombre").val(data["nombre"]);
            $("#mail").val(data["mail"]);
            $("#pass").val("");

            url = "accion/modificarUsuario.php";
        }
    });
}

function destroyMenu() {
    $("#tabla tbody").on("click", "button", function() {
        var data = $("#tabla").DataTable().row($(this).parents("tr")).data();

        if (data != null) {
            $("#title").html("Eliminar");
            $("#dlg").modal("show");

            limpiar();

            $("#edit-form").hide();
            $("#delete-form").show();

            $("#rol-name").text(data.nombre);
            $("#btn-submit").html("Eliminar");
            $("#btn-submit").removeClass("btn-primary").addClass("btn-danger");

            $("#id").val(data["id"]);
            $("#nombre").val(data["nombre"]);
            $("#mail").val(data["mail"]);

            url = "accion/eliminarUsuario.php";
        }
    });
}