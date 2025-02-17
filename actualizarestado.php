<?php
require 'vendor/autoload.php';

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan;
$coleccion = $bd->tareas;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nuevoEstado = $_POST['estado'];

    $coleccion->updateOne(
        ["_id" => new MongoDB\BSON\ObjectId($id)], //para coger id de mongo
        ['$set' => ["estado" => $nuevoEstado]]
    );

    echo "success";
} else {
    echo "error";
}
?>
