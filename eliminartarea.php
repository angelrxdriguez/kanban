<?php
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$bd = $cliente->kanvan;
$coleccion = $bd->tareas;

// 2. Verificar si hay un ID recibido
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // 3. Preparar y ejecutar la consulta SQL para eliminar
    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // 4. Redirigir a la página principal después de eliminar
        header("Location: index.php?mensaje=eliminado");
        exit();
    } else {
        echo "Error al eliminar la tarea.";
    }

    $stmt->close();
} else {
    echo "ID de tarea no válido.";
}

// 5. Cerrar conexión
$conn->close();
?>
