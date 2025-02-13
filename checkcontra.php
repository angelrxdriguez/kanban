<?php
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->kanvan; 
$collection = $database->usuarios; 

// Recoger datos del formulario
$username = trim($_POST['nombre']);
$password1 = $_POST['contra1'];
$password2 = $_POST['contra2'];

// Verificar que los campos no estén vacíos
if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>alert('Por favor, completa todos los campos.'); window.location.href='registro.html';</script>";
    exit();
}

// Verificar si las contraseñas coinciden
if ($password1 !== $password2) {
    echo "<script>alert('LAS CONTRASEÑAS NO COINCIDEN'); window.location.href='registro.html';</script>";
    exit();
}

// Comprobar si el usuario ya existe
$user = $collection->findOne(['nombre' => $username]);

if ($user) {
    echo "<script>alert('EL NOMBRE YA ESTÁ EN USO'); window.location.href='registro.html';</script>";
    exit();
}

// Insertar el usuario en la base de datos con la contraseña sin encriptar
$result = $collection->insertOne([
    'nombre' => $username,
    'contra' => $password1
]);

// Verificar si se creó correctamente
if ($result->getInsertedCount() > 0) {
    echo "<script>alert('USUARIO REGISTRADO CORRECTAMENTE'); window.location.href='log.html';</script>";
} else {
    echo "<script>alert('NO SE HA PODIDO REGISTRAR'); window.location.href='registro.html';</script>";
}
?>
