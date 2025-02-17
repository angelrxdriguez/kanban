<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="log.html">
            <img src="fotos/logo.jpg" alt="Logo" height="90" class="foto">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">TABLERO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="log.html">USUARIO</a>
                    <p class="usuario">
                        <?php 
                        if (isset($_SESSION['usuario'])) {
                            echo $_SESSION['usuario']; 
                        }
                        ?>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container50">
  <div class="containertit">
    <h1 class="tit">TASK</h1>
  </div>
  <div class="containerenlace">
    <a href="kanban.php" class="kanbanenlace">KANBAN</a>
  </div>
  <div class="containertit">
    <h1 class="tit">INFO</h1>
  </div>
  <div class="contenedor">
    <div class="columnaizq">
      <h2>IDEA</h2>
      <p>En la seccion de idea , planearás tu tarea. Una vez este todo pensado se mueve a la lista por hacer</p>
    </div>
    <div class="columna">
      <h2>POR HACER</h2>
      <p>En la seccion de idea , planearás tu tarea. Una vez este todo pensado se mueve a la lista por hacer</p>
    </div>
    <div class="columnader">
      <h2>HACIENDO</h2>
      <p>En la seccion de idea , planearás tu tarea. Una vez este todo pensado se mueve a la lista por hacer</p>
    </div>
    <div class="columnader2">
      <h2>HECHO</h2>
      <p>En la seccion de idea , planearás tu tarea. Una vez este todo pensado se mueve a la lista por hacer</p>
    </div>
  </div>
</div>
<footer>
  
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
