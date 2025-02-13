<?php
session_start();
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->kanvan; 
$collection = $database->usuarios; 

$username = $_POST['nombre'];
$password = $_POST['contra'];

$user = $collection->findOne(['nombre' => $username]);

if ($user) {
    if ($password === $user['contra']) {
        $_SESSION['usuario'] = $username; // Guardamos el usuario en la sesión
        header('Location: index.php'); // Redirigir a index.php en lugar de index.html
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='log.html';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='log.html';</script>";
}
?>
