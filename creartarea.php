<?php
// 1️⃣ Conectar a MongoDB
require 'vendor/autoload.php'; // Asegúrate de que tienes Composer y MongoDB PHP Driver instalado
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client( $uri);
$bd = $cliente->kanvan; // Nombre de la base de datos
$coleccion = $bd->tareas; // Nombre de la colección

// 2️⃣ Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearTarea"])) {
    // Capturar datos del formulario
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $colaboradores = trim($_POST["colaboradores"]);

    // 3️⃣ Crear el documento para MongoDB
    $tarea = [
        "titulo" => $titulo,
        "descripcion" => $descripcion,
        "colaboradores" => $colaboradores,
        "estado" => "idea", // Estado inicial de la tarea
        "fecha_creacion" => new MongoDB\BSON\UTCDateTime() // Fecha actual
    ];

    // 4️⃣ Insertar en la base de datos
    $resultado = $coleccion->insertOne($tarea);

    // 5️⃣ Confirmar inserción y redirigir
    if ($resultado->getInsertedCount() > 0) {
        echo "<script>alert('Tarea creada correctamente'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error al crear la tarea');</script>";
    }
}
?>
