<?php
session_start();

require 'vendor/autoload.php'; 
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan; 
$coleccion = $bd->tareas; 

if (!isset($_SESSION['usuario'])) {
    die("<script>alert('Error: Usuario no logueado.'); window.location.href='log.html';</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearTarea"])) {

    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $colaboradores = trim($_POST["colaboradores"]);
    $creador = $_SESSION['usuario']; 
    $tarea = [
        "titulo" => $titulo,
        "descripcion" => $descripcion,
        "colaboradores" => $colaboradores ? [$colaboradores] : [], //HACER QUE SE CREEN EN EL MODAL**
        "creador" => $creador, 
        "estado" => "idea",
    ];

    $resultado = $coleccion->insertOne($tarea);

    if ($resultado->getInsertedCount() > 0) {
        echo "<script>alert('Tarea creada correctamente'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error al crear la tarea');</script>";
    }
}
?>


