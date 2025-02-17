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
            $("#editartarea input[name='id']").val(tareaId);
    
            $("#editartarea").modal("show");
        });*/
        $(".editar").click(function () {
            let tarea = $(this).closest(".tarea");
            let tareaId = tarea.attr("data-id"); //usar data id en todo**
            let titulo = tarea.find(".tittarea").text();
            let descripcion = tarea.find(".destarea").text();
            let colaboradores = tarea.find(".colaboradores").text();
    
            //modal editar campos ***************
            $("#editartarea-id").val(tareaId);
            $("#editartarea-titulo").val(titulo);
            $("#editartarea-descripcion").val(descripcion);
            $("#editartarea-colaboradores").val(colaboradores);
    

            $("#editartarea").modal("show");//modal
        });

        $("#editarform").submit(function (e) {
            e.preventDefault(); //sin esto no va
    
            $.ajax({
                url: "editartarea.php",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response === "success") {
                        let tareaId = $("#editartarea-id").val();
                        let tarea = $(".tarea[data-id='" + tareaId + "']");
    
                        //actualizar mete .text id de el form
                        tarea.find(".tittarea").text($("#editartarea-titulo").val());
                        tarea.find(".destarea").text($("#editartarea-descripcion").val());
                       // tarea.find(".colaboradores").text($("#editartarea-colaboradores").val());  METER DESPUES**
    
                        $("#editartarea").modal("hide");
                    } else {
                        alert("tarea editada...");
                        location.reload();
                        $("#editartarea").modal("hide");

                    }
                },
                error: function () {
                    alert("error en la soli");
                }
            });
        });
    
        //eliminar *****************
        $("#eliminarbtn").click(function () {
            let tareaId = $("#editartarea-id").val(); //id tarea !!!**
    
            $.ajax({
                url: "eliminartarea.php",
                type: "POST",
                data: { id: tareaId },
                success: function (response) {
                    if (response === "success") {
                        $(".tarea[data-id='" + tareaId + "']").remove(); //se lo carga
                        $("#editartarea").modal("hide"); 
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
$(".colaborador").on("click", function() {
    let tareaId = $(this).closest(".tarea").attr("data-id"); //id tarea 
    $("#tareaId").val(tareaId); //campo oculto de e l id
    $("#modalColaborador").modal("show"); 
});

$("#formColaborador").on("submit", function(event) {
    event.preventDefault();

    let nombreColaborador = $("#nombreColaborador").val();
    let tareaId = $("#tareaId").val();

    if (!nombreColaborador || !tareaId) { //check si no esta 
        alert("mete el nombre de el colaborador");
        return;
    }

    $.ajax({
        url: "agregarColaborador.php",
        type: "POST",
        data: { nombreColaborador: nombreColaborador, tareaId: tareaId },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert(response.message);
                
                //sin recargar pagina
                let tareaDiv = $(".tarea[data-id='" + tareaId + "']");
                let colaboradoresP = tareaDiv.find(".colaboradores");

                if (colaboradoresP.text().trim() === "Sin colaboradores") {
                    colaboradoresP.text(response.colaborador);
                } else {
                    colaboradoresP.append(", " + response.colaborador);
                }

                $("#modalColaborador").modal("hide"); 
            } else {
                alert(response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: ", textStatus, errorThrown, jqXHR.responseText);
            alert("Hubo un error: " + jqXHR.responseText);
        }
        
    });
});
});