$(document).ready(function () {
    // Definir el orden de los estados
    let estados = ["idea", "hacer", "haciendo", "hecho"];

    // Manejar el botón "siguiente"
    $(".siguiente").click(function () {
        let tarea = $(this).closest(".tarea"); // Encuentra la tarea más cercana
        let estadoActual = tarea.parent().attr("class").split(" ")[0]; // Obtiene la clase del contenedor
        let nuevoEstadoIndex = estados.indexOf(estadoActual) + 1;

        if (nuevoEstadoIndex < estados.length) {
            let nuevoEstado = estados[nuevoEstadoIndex];

            // Llamada AJAX para actualizar en la base de datos
            actualizarEstadoTarea(tarea, nuevoEstado);
        }
    });

    // Manejar el botón "atras"
    $(".atras").click(function () {
        let tarea = $(this).closest(".tarea");
        let estadoActual = tarea.parent().attr("class").split(" ")[0];
        let nuevoEstadoIndex = estados.indexOf(estadoActual) - 1;

        if (nuevoEstadoIndex >= 0) {
            let nuevoEstado = estados[nuevoEstadoIndex];

            // Llamada AJAX para actualizar en la base de datos
            actualizarEstadoTarea(tarea, nuevoEstado);
        }
    });
    function actualizarEstadoTarea(tarea, nuevoEstado) {
        let tareaId = tarea.attr("data-id"); // Asegúrate de que cada tarea tenga un atributo `data-id`
        
        $.ajax({
            url: "actualizarestado.php",
            type: "POST",
            data: { id: tareaId, estado: nuevoEstado },
            success: function (response) {
                if (response === "success") {
                    // Mover la tarea a la nueva columna
                    tarea.appendTo("." + nuevoEstado);
                } else {
                    alert("Error al actualizar la tarea.");
                }
            },
            error: function () {
                alert("Error en la solicitud AJAX.");
            }
        });
    }
        /*$(".editar").click(function () {
            let tarea = $(this).closest(".tarea");  
            let tareaId = tarea.attr("data-id");
            let titulo = tarea.find(".tittarea").text();
            let descripcion = tarea.find(".destarea").text();
            let colaboradores = tarea.find(".colaboradores").text();
    
            // Llenamos el modal con los datos actuales
            $("#editartarea input[name='titulo']").val(titulo);
            $("#editartarea textarea[name='descripcion']").val(descripcion);
            $("#editartarea input[name='colaboradores']").val(colaboradores);
            $("#editartarea input[name='id']").val(tareaId); // Guardamos el ID en un campo oculto
    
            $("#editartarea").modal("show");
        });*/
        $(".editar").click(function () {
            let tarea = $(this).closest(".tarea");
            let tareaId = tarea.attr("data-id");
            let titulo = tarea.find(".tittarea").text();
            let descripcion = tarea.find(".destarea").text();
            let colaboradores = tarea.find(".colaboradores").text();
    
            // Llenamos los campos en el modal de edición
            $("#editartarea-id").val(tareaId);
            $("#editartarea-titulo").val(titulo);
            $("#editartarea-descripcion").val(descripcion);
            $("#editartarea-colaboradores").val(colaboradores);
    
            // Abrimos el modal
            $("#editartarea").modal("show");
        });
    
        // Enviar el formulario de edición con AJAX
        $("#edit-tarea-form").submit(function (e) {
            e.preventDefault(); // Evitar el envío tradicional
    
            $.ajax({
                url: "editartarea.php",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response === "success") {
                        let tareaId = $("#editartarea-id").val();
                        let tarea = $(".tarea[data-id='" + tareaId + "']");
    
                        // Actualizar los valores en la tarjeta
                        tarea.find(".tittarea").text($("#editartarea-titulo").val());
                        tarea.find(".destarea").text($("#editartarea-descripcion").val());
                        tarea.find(".colaboradores").text($("#editartarea-colaboradores").val());
    
                        $("#editartarea").modal("hide");
                    } else {
                        alert("Error al actualizar la tarea.");
                    }
                },
                error: function () {
                    alert("Error en la solicitud AJAX.");
                }
            });
        });
    
        // Eliminar tarea con AJAX
        $("#eliminar-tarea-btn").click(function () {
            let tareaId = $("#editartarea-id").val(); // Obtener el ID de la tarea
    
            $.ajax({
                url: "eliminartarea.php",
                type: "POST",
                data: { id: tareaId },
                success: function (response) {
                    if (response === "success") {
                        $(".tarea[data-id='" + tareaId + "']").remove(); // Eliminar del DOM
                        $("#editartarea").modal("hide"); // Cerrar el modal
                        alert("Tarea eliminada correctamente.");
                    } else {
                        alert("Error al eliminar la tarea.");
                    }
                },
                error: function () {
                    alert("Error en la solicitud AJAX.");
                }
            });
})
/*colaborador*/
$(".colaborador").on("click", function () {
    const tareaId = $(this).closest(".tarea").data("id"); // Obtener el ID de la tarea
    $("#tareaId").val(tareaId); // Pasar el ID de la tarea al input oculto en el modal
    $("#modalColaborador").modal("show"); // Mostrar el modal
});

// Manejar el envío del formulario para agregar colaborador
$("#formColaborador").on("submit", function (e) {
    e.preventDefault(); // Prevenir el envío del formulario

    const nombreColaborador = $("#nombreColaborador").val().trim();
    const tareaId = $("#tareaId").val();

    if (!nombreColaborador) {
        alert("Por favor, ingresa un nombre de colaborador.");
        return;
    }

    // Enviar los datos al servidor con AJAX
    $.ajax({
        url: "agregarColaborador.php",
        type: "POST",
        data: {
            nombreColaborador: nombreColaborador,
            tareaId: tareaId,
        },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.success) {
                alert("Colaborador agregado con éxito.");
                $(`[data-id="${tareaId}"] .colaboradores`).append(
                    `<span>${nombreColaborador}</span> `
                ); // Actualizar la interfaz
                $("#modalColaborador").modal("hide"); // Cerrar el modal
            } else {
                alert(res.message); // Mostrar mensaje de error
            }
        },
        error: function () {
            alert("Hubo un error al agregar el colaborador.");
        },
    });
});
});