<?php
require 'vendor/autoload.php';

// Conexión a MongoDB
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan; 
$coleccionTareas = $bd->tareas;
$coleccionUsuarios = $bd->usuarios;

// Obtener datos enviados por AJAX
$nombreColaborador = $_POST['nombreColaborador'] ?? null;
$tareaId = $_POST['tareaId'] ?? null;

if (!$nombreColaborador || !$tareaId) {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos."
    ]);
    exit;
}

// Comprobar si el colaborador existe en la base de datos de usuarios
$usuario = $coleccionUsuarios->findOne(['nombre' => $nombreColaborador]);

if (!$usuario) {
    echo json_encode([
        "success" => false,
        "message" => "El colaborador no existe en la base de datos."
    ]);
    exit;
}

// Convertir tareaId a ObjectId
$tareaId = new MongoDB\BSON\ObjectId($tareaId);

// Agregar el colaborador a la tarea (guardamos el nombre, no el ID)
$resultado = $coleccionTareas->updateOne(
    ['_id' => $tareaId],
    ['$addToSet' => ['colaboradores' => $nombreColaborador]] // Guardamos el nombre
);

if ($resultado->getModifiedCount() > 0) {
    echo json_encode([
        "success" => true,
        "message" => "Colaborador agregado con éxito.",
        "colaborador" => $nombreColaborador
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo agregar el colaborador."
    ]);
}
?>
