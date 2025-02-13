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
        
            // También pasamos el ID al formulario de eliminación
            $("#eliminartarea-id").val(tareaId);
        
            // Abrimos el modal
            $("#editartarea").modal("show");
        });
        // Enviar el formulario de edición con AJAX
        $("#editartarea form").submit(function (e) {
            e.preventDefault(); // Evitar el envío tradicional
    
            $.ajax({
                url: "editartarea.php",
                type: "POST",
                data: $(this).serialize(), // Serializa los datos del formulario
                success: function (response) {
                    if (response === "success") {
                        let tareaId = $("#editartarea input[name='id']").val();
                        let nuevaTarea = $(".tarea[data-id='" + tareaId + "']");
                        
                        // Actualizar los valores en la tarjeta
                        nuevaTarea.find(".tittarea").text($("#editartarea input[name='titulo']").val());
                        nuevaTarea.find(".destarea").text($("#editartarea textarea[name='descripcion']").val());
                        nuevaTarea.find(".colaboradores").text($("#editartarea input[name='colaboradores']").val());
    
                        $("#editartarea").modal("hide"); // Cerrar el modal
                    } else {
                        alert("Error al actualizar la tarea.");
                    }
                },
                error: function () {
                    alert("Error en la solicitud AJAX.");
                }
            });
        });
        
        
});
