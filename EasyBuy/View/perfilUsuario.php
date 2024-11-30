<?php
    session_start();

    if(!isset($_SESSION['id'])){
      header('Location: inicio');
    }else if($_SESSION['tipo'] == 2){
      header('Location: home-store');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="Css/perfilUser.css">
  <link rel="stylesheet" href="Css/footer.css">
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
              <li><a class="dropdown-item" onclick="logOut()">Salir</a></li>
            </ul>
          </div>

        </form>
      </div>
    </div>
  </nav>

  <!-- Contenedor principal -->
  <div class="settings-container">
    <h2 class="text-center mb-4">Gestión de cuenta</h2>
    <div class="row">
      <!-- Menú lateral con pestañas -->
      <div class="col-12 mb-3">
        <div class="list-group d-flex flex-row justify-content-center" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active me-2" id="list-general-list" data-bs-toggle="list" href="#list-general" role="tab" aria-controls="general">Actualizar datos</a>
          <a class="list-group-item list-group-item-action me-2" id="list-password-list" data-bs-toggle="list" href="#list-password" role="tab" aria-controls="password">Cambiar contraseña</a>
          <a class="list-group-item list-group-item-action " id="list-history-list" data-bs-toggle="list" href="#list-history" role="tab" aria-controls="history">Historial de compras</a>
        </div>
      </div>

      <!-- Contenido dinámico -->
      <div class="col-12">
        <div class="tab-content" id="nav-tabContent">
          <!-- General -->
          <div class="tab-pane fade show active" id="list-general" role="tabpanel" aria-labelledby="list-general-list">
            <h3>Mis datos</h3>
            <form id="formActDatos">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" id="name" class="form-control" placeholder="Escribe tu nombre" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" id="lastname" class="form-control" placeholder="Escribe tu apellido" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" id="email" class="form-control" placeholder="Escribe tu correo" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Número de Teléfono</label>
                <input type="tel" id="phone" class="form-control" placeholder="Escribe tu número de teléfono" required>
              </div>
              <div class="col-md-6 input-box">
                <span class="details">Ciudad</span>
                <select class="form-select" id="city" required>
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
              <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" id="direccion" class="form-control" placeholder="Escribe tu dirección" required>
              </div>
              <br>
              <div align="center">
                <button class="btn btn-primary" onclick="actDatos()">Guardar Cambios</button>
              </div>
            </form>
          </div>

          <!-- Recuperar Contraseña -->
          <div class="tab-pane fade" id="list-password" role="tabpanel" aria-labelledby="list-password-list">
            <h3>Recuperar Contraseña</h3>
            <form id="formActPass">
              <div class="mb-3">
                <label class="form-label">Contraseña Actual</label>
                <input type="password" id="currentPassword" class="form-control" placeholder="Escribe tu contraseña actual" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Nueva Contraseña</label>
                <input type="password" id="newPassword" class="form-control" placeholder="Escribe tu nueva contraseña" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirma la Nueva Contraseña</label>
                <input type="password" id="confirmNewPassword" class="form-control" placeholder="Confirma tu nueva contraseña" required>
              </div>
              <button class="btn btn-primary" onclick="cambiarPass()">Actualizar Contraseña</button>
            </form>
          </div>

          <!-- Historial -->
          <div class="tab-pane fade" id="list-history" role="tabpanel" aria-labelledby="list-history-list">
            <h3>Historial de Pedidos</h3>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Producto</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Factura</th>
                </tr>
              </thead>
              <tbody id="contTablaHistComp">
              </tbody>
            </table>
          </div>
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

  <!-- Modal factura -->
  <div class="modal fade  modal-centered" id="modalFactura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5 w-100 text-center" id="tituloModalDetalle">¡Tu factura está lista!</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contenido modal -->
          <div class="invoice-container">
            <div class="invoice-header">
              <h1>Factura</h1>
              <p>ID de Factura: <strong id="fact-id"></strong></p>
              <p>Gracias por tu compra en EasyBuy</p>
            </div>

            <table class="invoice-details">
              <tr>
                <td><strong>Fecha del Pedido:</strong></td>
                <td id="fact-fecha"></td>
              </tr>
              <tr>
              <tr>
                <td><strong>Cliente:</strong></td>
                <td id="fact-cli"></td>
              </tr>
              <tr>
                <td><strong>Tienda:</strong></td>
                <td id="fact-store"></td>
              </tr>
                <td><strong>Ciudad:</strong></td>
                <td id="fact-ciudad"></td>
              </tr>
              <tr>
                <td><strong>Dirección:</strong></td>
                <td id="fact-direccion"></td>
              </tr>
              <tr>
                <td><strong>Método de Pago:</strong></td>
                <td id="fact-metodo"></td>
              </tr>
              <tr>
                <td><strong>Estado:</strong></td>
                <td id="fact-estado"></td>
              </tr>
            </table>

            <table class="invoice-items">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>1</td>
                <td id="fact-nombre">Smartphone Galaxy S22</td>
                <td id="fact-cant"></td>
                <td id="fact-precio"></td>
                <td id="fact-total1"></td>
              </tr>
              <tr class="invoice-total">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td id="fact-total2"></td>
              </tr>
              </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;">
              <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
              <p>¡Gracias por elegirnos!</p>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <div class="col" align="center">
            <button type="button" class="btn btn-success" onclick="imprimirFactura()">Imprimir</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php 
    include('footer.php');
    include('Js/perfilUser.js');
  ?>
</body>
</html>

