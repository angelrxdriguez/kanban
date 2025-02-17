<?php
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->kanvan; 
$collection = $database->usuarios; 

//formulario
$nombre = trim($_POST['nombre']);
$contra1 = $_POST['contra1'];
$contra2 = $_POST['contra2'];
//no meter vacios
if (empty($nombre) || empty($contra1) || empty($contra2)) {
    echo "<script>alert('Por favor, completa todos los campos.'); window.location.href='registro.html';</script>";
    exit();
}

//coinciden
if ($contra1 !== $contra2) {
    echo "<script>alert('LAS CONTRASEÑAS NO COINCIDEN'); window.location.href='registro.html';</script>";
    exit();
}

$user = $collection->findOne(['nombre' => $nombre]);

if ($user) {
    echo "<script>alert('EL NOMBRE YA ESTÁ EN USO'); window.location.href='registro.html';</script>";
    exit();
}

//mete en la base
$result = $collection->insertOne([
    'nombre' => $nombre,
    'contra' => $contra1
]);


if ($result->getInsertedCount() > 0) {
    echo "<script>alert('USUARIO REGISTRADO CORRECTAMENTE'); window.location.href='log.html';</script>";
} else {
    echo "<script>alert('NO SE HA PODIDO REGISTRAR'); window.location.href='registro.html';</script>";
}
?>
