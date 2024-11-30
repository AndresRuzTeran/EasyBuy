<?php

  session_start();

  if(isset($_SESSION['id'])){
    if($_SESSION['tipo'] == 1){
      header('Location: home');
    }else{
      header('Location: home-store');
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login </title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="proyect"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/inicioSesion.css">
  </head>
  
  <body>
    <div class="bg-info d-flex justify-content-center align-items-center vh-100 custom">
      <div class="bg-white p-5 rounded-5 text-secondary shadow" style="width: 25rem">
        <div class="d-flex justify-content-center">
          <img src="Img/Logo_Blanco.png" alt="LOGO.EASYBUY" style="height: 13rem"/>
        </div>

        <form id="formLogin">
          <div class="input-group mt-2">
            <div class="input-group-text bg-info">
              <img src="Img/username-icon.svg" alt="username-icon" style="height: 1rem" />
            </div>
            <input class="form-control bg-light" type="text" placeholder="Correo" required>
            <div class="invalid-feedback">
              Por favor ingrese su correo.
            </div>
          </div>
          <div class="input-group mt-1">
            <div class="input-group-text bg-info">
              <img src="Img/password-icon.svg" alt="password-icon" style="height: 1rem" />
            </div>
            <input class="form-control bg-light" type="password" placeholder="Contraseña" required>
            <div class="invalid-feedback">
              Por favor ingrese su contraseña.
            </div>
          </div>
        </form>

        <button type="button" class="btn btn-info text-white w-100 mt-4 fw-semibold shadow-sm" onclick="logIn()">Login</button>

        <div class="d-flex gap-1 justify-content-center mt-1">
          <div>¿No tienes una cuenta?</div>
          <a href="registro-usuarios" class="text-decoration-none text-info fw-semibold"
            >Regístrate</a
          >
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
      include('Js/inicioSesion.js');
    ?>
    
  </body>
</html>
