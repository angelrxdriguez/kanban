<?php
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$bd = $cliente->kanvan;
$coleccion = $bd->tareas;

//SI ID
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    try {
        //id mongo
        $resultado = $coleccion->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

        if ($resultado->getDeletedCount() > 0) {
            echo "ok";
        } else {
            echo "error";
        }
    } catch (Exception $e) {
        echo "error";
    }
} else {
    echo "error"; 
}
?>
