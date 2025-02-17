<?php
session_start();
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->kanvan; 
$collection = $database->usuarios; 

$nombre = $_POST['nombre'];
$contra = $_POST['contra'];

$user = $collection->findOne(['nombre' => $nombre]);

if ($user) {
    if ($contra === $user['contra']) {
        $_SESSION['usuario'] = $nombre; //para la sesion
        header('Location: index.php');
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='log.html';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='log.html';</script>";
}
?>
