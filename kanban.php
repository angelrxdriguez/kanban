<?php
require 'vendor/autoload.php'; 
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$cliente = new MongoDB\Client($uri);
$bd = $cliente->kanvan;  
$coleccion = $bd->tareas;

session_start();

//para que no te deje entrar por la url sin log
if (!isset($_SESSION['usuario'])) {
    die("<script>alert('Error:USUARIO NO REGISTRADO. LOGUEATE!!'); window.location.href='log.html';</script>");
}

$tareas = $coleccion->find();

$usuarioActual = $_SESSION['usuario'];

$listaTareas = [
    "idea" => [],
    "hacer" => [],
    "haciendo" => [],
    "hecho" => []
];

foreach ($tareas as $tarea) {
    $estado = strtolower($tarea['estado']); //minus
    
    //creador o admin
    if ((isset($tarea['creador']) && $tarea['creador'] === $usuarioActual) || $usuarioActual === 'admin') {
        if (isset($listaTareas[$estado])) {
            $listaTareas[$estado][] = $tarea;
        }
    }
    //colab
    elseif (isset($tarea['colaboradores']) && in_array($usuarioActual, (array)$tarea['colaboradores'])) {
        if (isset($listaTareas[$estado])) {
            unset($tarea['botones']); //se carga toda la clase botones
            $listaTareas[$estado][] = $tarea;
        }
    }
}



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KANBAN</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.0.2/dist/css/coreui.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bowlby+One+SC&display=swap" rel="stylesheet">
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

  <nav>
    <button class="btn btn-primary crear" data-bs-toggle="modal" data-bs-target="#creartarea">
        CREAR
    </button>
  </nav>

  <div class="separador"></div>

  <div class="tablerokanban">  
      <!-- columna IDEA -->
      <div class="idea columnak">
          <h2 class="titk">IDEA</h2>
          <?php foreach ($listaTareas["idea"] as $tarea): ?>
    <div class="tarea" data-id="<?= $tarea['_id'] ?>">
        <h5 class="tittarea"><?= $tarea['titulo'] ?></h5>
        <p class="destarea"><?= $tarea['descripcion'] ?></p>

        <?php if ($tarea['creador'] === $usuarioActual || $usuarioActual === 'admin'): ?>
            <div class="botones">
                <button class="atras"><img src="icono/anterior.png" alt="" class="flecha"></button>
                <button class="colaborador"><img src="icono/add-group.png" alt="" class="icono"></button>
                <button class="editar"><img src="icono/edit.png" alt="" class="icono"></button>
                <button class="siguiente"><img src="icono/siguiente.png" alt="" class="flecha"></button>
            </div>
        <?php endif; ?>

        <p class="colaboradores">
            <?= isset($tarea['colaboradores']) && is_array($tarea['colaboradores']) 
                ? implode(" ", $tarea['colaboradores']) 
                : ""; ?>
        </p>
    </div>
<?php endforeach; ?>
      </div>

      <!-- columna HACER -->
      <div class="hacer columnak">
          <h2 class="titk">HACER</h2>
          <?php foreach ($listaTareas["hacer"] as $tarea): ?>
    <div class="tarea" data-id="<?= $tarea['_id'] ?>">
        <h5 class="tittarea"><?= $tarea['titulo'] ?></h5>
        <p class="destarea"><?= $tarea['descripcion'] ?></p>

        <?php if ($tarea['creador'] === $usuarioActual || $usuarioActual === 'admin'): ?>
            <div class="botones">
                <button class="atras"><img src="icono/anterior.png" alt="" class="flecha"></button>
                <button class="colaborador"><img src="icono/add-group.png" alt="" class="icono"></button>
                <button class="editar"><img src="icono/edit.png" alt="" class="icono"></button>
                <button class="siguiente"><img src="icono/siguiente.png" alt="" class="flecha"></button>
            </div>
        <?php endif; ?>

        <p class="colaboradores">
            <?= isset($tarea['colaboradores']) && is_array($tarea['colaboradores']) 
                ? implode(" ", $tarea['colaboradores']) 
                : ""; ?>
        </p>
    </div>
<?php endforeach; ?>
      </div>

      <!-- columna HACIENDO -->
      <div class="haciendo columnak">
          <h2 class="titk">HACIENDO</h2>
          <?php foreach ($listaTareas["haciendo"] as $tarea): ?>
    <div class="tarea" data-id="<?= $tarea['_id'] ?>">
        <h5 class="tittarea"><?= $tarea['titulo'] ?></h5>
        <p class="destarea"><?= $tarea['descripcion'] ?></p>

        <?php if ($tarea['creador'] === $usuarioActual || $usuarioActual === 'admin'): ?>
            <div class="botones">
                <button class="atras"><img src="icono/anterior.png" alt="" class="flecha"></button>
                <button class="colaborador"><img src="icono/add-group.png" alt="" class="icono"></button>
                <button class="editar"><img src="icono/edit.png" alt="" class="icono"></button>
                <button class="siguiente"><img src="icono/siguiente.png" alt="" class="flecha"></button>
            </div>
        <?php endif; ?>

        <p class="colaboradores">
            <?= isset($tarea['colaboradores']) && is_array($tarea['colaboradores']) 
                ? implode(" ", $tarea['colaboradores']) 
                : ""; ?>
        </p>
    </div>
<?php endforeach; ?>
      </div>

      <!-- columna HECHO -->
      <div class="hecho columnak">
          <h2 class="titk">HECHO</h2>
          <?php foreach ($listaTareas["hecho"] as $tarea): ?>
    <div class="tarea" data-id="<?= $tarea['_id'] ?>">
        <h5 class="tittarea"><?= $tarea['titulo'] ?></h5>
        <p class="destarea"><?= $tarea['descripcion'] ?></p>

        <?php if ($tarea['creador'] === $usuarioActual || $usuarioActual === 'admin'): ?>
            <div class="botones">
                <button class="atras"><img src="icono/anterior.png" alt="" class="flecha"></button>
                <button class="colaborador"><img src="icono/add-group.png" alt="" class="icono"></button>
                <button class="editar"><img src="icono/edit.png" alt="" class="icono"></button>
                <button class="siguiente"><img src="icono/siguiente.png" alt="" class="flecha"></button>
            </div>
        <?php endif; ?>

        <p class="colaboradores">
            <?= isset($tarea['colaboradores']) && is_array($tarea['colaboradores']) 
                ? implode(" ", $tarea['colaboradores']) 
                : ""; ?>
        </p>
    </div>
<?php endforeach; ?>
      </div>
  </div>
    <!--modal crearTarea-->
  <div class="modal fade" id="creartarea" tabindex="-1" aria-labelledby="creartareaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="creartareaLabel">Crear Nueva Tarea</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="creartarea.php" method="post">
            <input type="hidden" name="creador" value="<?php echo $_SESSION['usuario']; ?>">
            <input type="hidden" name="id">
                <div class="mb-3">
                    <label for="tituloTarea" class="form-label">Título de la Tarea</label>
                    <input type="text" class="form-control" name="titulo" placeholder="Escribe el título" required>
                </div>
                <div class="mb-3">
                    <label for="descripcionTarea" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" placeholder="Describe la tarea" required></textarea>
                </div>
               <!-- <div class="mb-3">
                    <label for="colaboradores" class="form-label">Colaboradores</label>
                    <input type="text" class="form-control" name="colaboradores" placeholder="SOLO UN COLABORADOR">
                </div>-->
                <button type="submit" class="btn btn-primary" name="crearTarea">Crear</button>
            </form>
            
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" name="crearTarea">Cancelar</button>
         
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Editar Tarea -->
   
  <div class="modal fade" id="editartarea" tabindex="-1" aria-labelledby="editartareaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editartareaLabel">Editar Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarform" method="post">
                    <input type="hidden" name="id" id="editartarea-id">
                    <div class="mb-3">
                        <label for="tituloTarea" class="form-label">Título de la Tarea</label>
                        <input type="text" class="form-control" name="titulo" id="editartarea-titulo" placeholder="Escribe el título" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionTarea" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="editartarea-descripcion" rows="3" placeholder="Describe la tarea" required></textarea>
                    </div>
                   <!-- <div class="mb-3">
                        <label for="colaboradores" class="form-label">Colaboradores</label>
                        <input type="text" class="form-control" name="colaboradores" id="editartarea-colaboradores" placeholder="Ingrese el nombre correcto">
                    </div>-->
                    <button type="submit" class="btn btn-primary" name="editarTarea">EDITAR</button>
                </form>
                <div class="mt-4 text-center">
                    <h4>¿Eliminar Tarea?</h4>
                    <button id="eliminarbtn" class="btn btn-danger">Eliminar</button>
                    <h6 class="mt-2 text-danger">¡CUIDADO! Tu tarea no se volverá a mostrar.</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Agregar Colaborador -->
<div class="modal fade" id="modalColaborador" tabindex="-1" aria-labelledby="modalColaboradorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalColaboradorLabel">Agregar Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formColaborador">
                    <div class="mb-3">
                        <label for="nombreColaborador" class="form-label">Nombre del Colaborador</label>
                        <input type="text" class="form-control" id="nombreColaborador" name="nombreColaborador" placeholder="Ingresa el nombre del colaborador" required>
                    </div>
                    <input type="hidden" id="tareaId" name="tareaId">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
