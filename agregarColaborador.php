<?php
require 'vendor/autoload.php';

// Conexión a MongoDB
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan; 
$coleccionTareas = $bd->tareas;
$coleccionUsuarios = $bd->usuarios; // Asegúrate de tener esta colección

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

// Comprobar si el colaborador existe en la colección de usuarios
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

// Agregar el colaborador a la tarea
$resultado = $coleccionTareas->updateOne(
    ['_id' => $tareaId],
    ['$addToSet' => ['colaboradores' => $usuario['_id']]] // Guardamos el ID del usuario como colaborador
);

if ($resultado->getModifiedCount() > 0) {
    echo json_encode([
        "success" => true,
        "message" => "Colaborador agregado con éxito.",
        "colaborador" => $usuario['nombre'] // Devolvemos el nombre para mostrarlo en la interfaz
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo agregar el colaborador."
    ]);
}
