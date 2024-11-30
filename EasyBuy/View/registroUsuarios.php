<?php

session_start();

if (isset($_SESSION['id'])) {
  if ($_SESSION['tipo'] == 1) {
    header('Location: home');
  } else {
    header('Location: home-store');
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
  <title>Regístrate</title>
  <link rel="stylesheet" type="text/css" href="Css/registro.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* Asegura que el contenido del formulario esté debajo de la barra de navegación */
    .form-container {
      margin-top: 100px;
      /* Ajusta este valor para dar espacio suficiente al formulario debajo del navbar */
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
      background-color: #ffffff;
      /* Fondo blanco para el formulario */
      border-radius: 8px;
      /* Bordes redondeados */
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      /* Sombra para darle profundidad */
    }

    /* Fondo de la página general */
    body {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-md bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="inicio">
        <img src="Img/Logo_sin_fondo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        Easybuy
      </a>
    </div>
  </nav>


  <div class="registro-container">
    <!-- Contenedor principal para centrar el formulario -->
    <div class="form-container mt-5">
      <!-- Formulario -->
      <div class="col-md-12">
        <!-- Título -->
        <div class="title text-center mb-4">Regístrate</div>
        <div class="content">
          <!-- Formulario de registro -->
          <form id="formReg">
            <div class="user-details row g-3">
              <!-- Nombre -->
              <div class="col-md-6 input-box">
                <span class="details">Nombre</span>
                <input type="text" class="form-control" placeholder="Ingresa tu nombre." required>
              </div>
              <!-- Apellido -->
              <div class="col-md-6 input-box">
                <span class="details">Apellido</span>
                <input type="text" class="form-control" placeholder="Ingresa tu apellido." required>
              </div>
              <!-- Correo electrónico -->
              <div class="col-md-6 input-box">
                <span class="details">Correo electrónico</span>
                <input type="email" class="form-control" placeholder="Ingresa tu correo." required>
              </div>
              <!-- Teléfono -->
              <div class="col-md-6 input-box">
                <span class="details">Teléfono</span>
                <input type="tel" class="form-control" placeholder="Ingresa tu teléfono." required>
              </div>
              <!-- Contraseña -->
              <div class="col-md-6 input-box">
                <span class="details">Contraseña</span>
                <input type="password" class="form-control" placeholder="Ingresa la contraseña" id="pass1" required>
              </div>
              <!-- Confirmación de contraseña -->
              <div class="col-md-6 input-box">
                <span class="details">Repite la contraseña</span>
                <input type="password" class="form-control" placeholder="Confirma tu contraseña." id="pass2" required>
              </div>
              <!-- Ciudad -->
              <div class="col-md-6 input-box">
                <span class="details">Ciudad</span>
                <select class="form-select" required>
                  <option value="" disabled selected>Selecciona tu ciudad</option>
                  <option value="bogota">Bogotá D.C.</option>
                  <option value="medellin">Medellín</option>
                  <option value="cali">Cali</option>
                  <option value="barranquilla">Barranquilla</option>
                  <option value="cartagena">Cartagena</option>
                  <option value="cucuta">Cúcuta</option>
                  <option value="bucaramanga">Bucaramanga</option>
                  <option value="pereira">Pereira</option>
                  <option value="santa_marta">Santa Marta</option>
                  <option value="ibague">Ibagué</option>
                  <option value="bello">Bello</option>
                  <option value="pasto">Pasto</option>
                  <option value="manizales">Manizales</option>
                  <option value="neiva">Neiva</option>
                  <option value="armenia">Armenia</option>
                </select>
              </div>
              <!-- Dirección -->
              <div class="col-md-6 input-box">
                <span class="details">Dirección</span>
                <input type="text" class="form-control" placeholder="Ingresa tu dirección." required>
              </div>
            </div>
            <!-- Botón de registro -->
            <div class="button mt-4 text-center">
              <input class="btn btn-primary" value="¡Regístrate ya!" onclick="registrarse()">
            </div>
            <div align="center">
              <a href="inicio">¿Ya tiene una cuenta?, iniciar sesión</a>
            </div>
          </form>
        </div>
      </div>
    </div>
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
  include('Js/registro.js');
  ?>
</body>

</html>