<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
    <title>Nosotros</title>
    <link rel="stylesheet" type="text/css" href="Css/aboutUs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="proyect"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/footer.css">
    <style>
      body {
        background-color: #f2f2f2;
        margin-top: 60px;
        /* Ajusta este valor según la altura del navbar */
      }

      .navbar {
        height: 60px;
        /* Asegúrate de establecer una altura fija al navbar */
      }

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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          </ul>
          <form class="d-flex">
            <?php
              if(isset($_SESSION['id'])){
                echo 
                '<div class="dropdown-center">
                  <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="Img/perfil.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    Mi perfil
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">'.
                    ($_SESSION['tipo'] == 1?'<li><a class="dropdown-item" href="perfil-usuario">Gestión de cuenta</a></li>':'').
                    '<li><a class="dropdown-item" onclick="logOut()">Salir</a></li>
                  </ul>
                </div>';
              }
            
            ?>
          </form>
        </div>
      </div>
    </nav>
    <br><br><br>

    <div class="heading">
      <h1>Sobre nosotros</h1>
      <p>EasyBuy es un ecommerce colombiano que ofrece compras fáciles, rápidas y seguras en todo el país.</p>
    </div>
    <div class="container">
      <section class="about">
        <div class="about-image">
          <img src="Img/bannerAboutUs.png">
        </div>
        <div class="about-content">
          <p>
            En EasyBuy nos apasiona conectar a Colombia con una experiencia de compra en línea sencilla, segura y confiable. Somos una plataforma 100% colombiana creada para
            ofrecerte los mejores productos al alcance de un clic, con precios competitivos y entregas rápidas en todo el país.
            Creemos en facilitar tu día a día con un servicio excepcional, donde tus necesidades son nuestra prioridad. ¡Descubre cómo es comprar fácil, comprar colombiano, comprar con EasyBuy!
          </p>
          <a href="inicio" class="compra-ya">¡Compra ya!</a>
        </div>
      </section>
    </div>


    <?php
      include('footer.php');
      include('Js/aboutUs.js');
    ?>

  </body>
</html>