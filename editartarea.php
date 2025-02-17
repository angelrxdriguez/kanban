<?php
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$bd = $cliente->kanvan;
$coleccion = $bd->tareas;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    //$colaboradores = $_POST['colaboradores'];

    $resultado = $coleccion->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            //'colaboradores' => $colaboradores
        ]]
    );

    if ($resultado->getModifiedCount() > 0) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
