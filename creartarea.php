<?php
session_start();

require 'vendor/autoload.php'; // Asegúrate de que tienes Composer y MongoDB PHP Driver instalado
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan; // Nombre de la base de datos
$coleccion = $bd->tareas; // Nombre de la colección

if (!isset($_SESSION['usuario'])) {
    die("<script>alert('Error: Usuario no logueado.'); window.location.href='log.html';</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearTarea"])) {
    // Capturar datos del formulario
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $colaboradores = trim($_POST["colaboradores"]);
    $creador = $_SESSION['usuario']; // Nombre del usuario logueado

    $tarea = [
        "titulo" => $titulo,
        "descripcion" => $descripcion,
        "colaboradores" => $colaboradores ? [$colaboradores] : [], // Si no hay colaboradores, usa un arreglo vacío
        "creador" => $creador, // Agregar el creador de la tarea
        "estado" => "idea", // Estado inicial de la tarea
    ];

    $resultado = $coleccion->insertOne($tarea);

    if ($resultado->getInsertedCount() > 0) {
        echo "<script>alert('Tarea creada correctamente'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error al crear la tarea');</script>";
    }
}
?>


