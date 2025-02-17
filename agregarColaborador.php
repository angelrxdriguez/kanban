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

//var usuario para el nombre dentro de todos los usuarios
$usuario = $coleccionUsuarios->findOne(['nombre' => $nombreColaborador]);

if (!$usuario) {
    echo json_encode([
        "success" => false,
        "message" => "El colaborador no existe en la base de datos."
    ]);
    exit;
}

//id de mongo
$tareaId = new MongoDB\BSON\ObjectId($tareaId);

//guarda nombre no id
$resultado = $coleccionTareas->updateOne(
    ['_id' => $tareaId],
    ['$addToSet' => ['colaboradores' => $nombreColaborador]] 
);

if ($resultado->getModifiedCount() > 0) { //si es mayor que 0 es pq algo se hizo
    echo json_encode([
        "success" => true,
        "message" => "colaborador metido",
        "colaborador" => $nombreColaborador
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "error"
    ]);
}
?>
