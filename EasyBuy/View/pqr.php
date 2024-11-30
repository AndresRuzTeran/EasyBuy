<?php
    session_start();

    if(!isset($_SESSION['id'])){
      header('Location: inicio');
    }else if($_SESSION['tipo'] == 2){
      header('Location: home-store');
    }
?>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
    <title>Formulario PQRS</title>
    <link rel="stylesheet" href="Css/footer.css">
    <link rel="stylesheet" href="Css/pqrs.css">
  </head>
  <body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-md bg-body-tertiary fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="inicio">
          <img src="Img/Logo_sin_fondo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            Easybuy
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home">Inicio</a>
            </li>
          </ul>
          <form class="d-flex">
            <div class="dropdown-center">
              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="Img/perfil.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                Mi perfil
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="perfil-usuario">Gestión de cuenta</a></li>
                <li><a class="dropdown-item" onclick="logOut()">Salir</a></li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </nav>
    <br><br><br>

    <!-- Contenedor del formulario PQRS -->
    <div class="container container-pqrs">
      <h1>Formulario PQRS</h1>
      <p>Por favor, completa este formulario para enviarnos tu Petición, Queja, Reclamo o Sugerencia.</p>

      <!-- Formulario de PQRS -->
      <form id="pqrsForm">
        <div class="form-group">
          <label for="tipo">Tipo de solicitud:</label>
          <select id="tipo" name="tipo" class="form-control" required>
            <option value="1">Petición</option>
            <option value="2">Queja</option>
            <option value="3">Reclamo</option>
            <option value="4">Sugerencia</option>
          </select>
        </div>

        <div class="form-group">
          <label for="asunto">Asunto:</label>
          <input type="text" id="asunto" name="asunto" class="form-control" maxlength="100" required>
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción:</label>
          <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
          <input class="btn btn-primary btn-submit" value="Enviar" onclick="enviar()">
        </div>
      </form>
    </div>

    <!-- Modal success -->
    <div class="modal fade" id="modalSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="tituloSuccess">Exitoso</h1>
          </div>
          <div class="modal-body">
            <p id="mensajeSuccess"></p>
          </div>
          <div class="modal-footer">
            <div class="col-4 col-sm-7">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal error -->
    <div class="modal fade" id="modalError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="tituloSuccess">Error</h1>
          </div>
          <div class="modal-body">
            <p id="mensajeError"></p>
          </div>
          <div class="modal-footer">
            <div class="col-4 col-sm-7">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php 
      include('footer.php');
      include('Js/contactanos.js');
    ?>
  </body>
</html>
