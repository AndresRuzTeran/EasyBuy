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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="proyect"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/inicio.css">
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
  <!-- Inicio Contenido -->
  <h1 id="saludo" align="center">Productos Disponibles</h1>

    <div class="container">

    <!-- Filtros -->
    <div class="filters">
        <form id="filtros">
          <div class="row">
            <!-- Filtro por Categoría -->
            <div class="col-md-3">
              <label class="form-label">Categoría</label>
              <select class="form-select" id="slcCategoria">
              </select>
            </div>

            <!-- Filtro por Precio -->
            <div class="col-md-3">
              <label class="form-label">Rango de Precio</label>
              <select class="form-select" id="precio" name="precio">
                <option value="0">Selecciona un rango</option>
                <option value="1">Menos de $100.000</option>
                <option value="2">$100.000 - $500.000</option>
                <option value="3">$500.000 - $1.000.000</option>
                <option value="4">Más de $1.000.000</option>
              </select>
            </div>

            <!-- Filtro por nombre -->
            <div class="col-md-3">
              <label class="form-label">Buscar por nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ejemplo: iphone">
            </div>

            <!-- Botón de filtro -->
            <div class="col-md-3 d-flex align-items-end">
              <button class="btn btn-primary" onclick="cargarInfoProducts()">Aplicar Filtros</button>
            </div>
          </div>
        </form>
      </div>
      <br>


      <div class="products-grid" id="gridProducts">
      </div>
    </div>

  <!-- Fin Contenido -->

  <!-- Carrito -->

  <div class="row">
    <div class="col">
      <div class="collapse multi-collapse floating-collapse" id="multiCollapseExample1">
        <div class="card card-body" style="width: 700px;" id="cardCarrito">

          <h5>Carrito de Compras</h5>
          <table class="table table-striped">
              <thead>
                  <tr style="text-align: center;">
                    <th colspan="2">Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acción</th>
                  </tr>
              </thead>
              <tbody id="contenidoCarrito">
              </tbody>
          </table>
          <div class="text-end fw-bold" id="totalCarritoFinal">
          </div>
          <div align="center">
            <button type="button" class="btn btn-primary" id="pagarAhoraCart" onclick="openModalCompra()">Comprar</button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <button class="floating-button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample1" aria-expanded="false" id="buttonCarrito">
    <img src="Img/shoppingcart.png" alt="Icono de acción" width="40" height="40">
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="spanCarrito" hidden>
      1
    </span>
  </button>

  
  


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

  <!-- Modal detalle Producto -->
  <div class="modal fade  modal-centered" id="modalDetalleProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5 w-100 text-center" id="tituloModalDetalle">Detalle de<b> Smartphone Galaxy S22</b></h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contenido modal -->
          <form id="formNuevoViatico">
            <input type="hidden" id="idProductModalDetalle">
            <div class="mb-3">
              <div class="text-center">
                <img class="img-fluid rounded" src="" alt="..." id="imgModalDetalle">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label"><b>Descripción:</b></label>
              <label class="form-label" id="descModalDetalle"></label>
            </div>
            <div class="mb-3">
              <label class="form-label"><b>Precio: </b></label>
              <label class="form-label" id="precioModalDetalle">$4,500,000</label>
            </div>
            <div class="mb-3">
              <label class="form-label"><b>Categoría: </b></label>
              <label class="form-label" id="catModalDetalle"></label>
            </div>
            <div class="mb-3">
              <label class="form-label">Cantidad: </label>
              <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-secondary" onclick="decrementQuantity(null,this)">-</button>
                <input type="number" id="spinerModalDetalle" class="form-control no-arrows" style="width: 50px;border-radius:0px;" value="1">
                <button type="button" class="btn btn-secondary" onclick="incrementQuantity(null,this)">+</button>
              </div>
            </div>
            
          </form>

        </div>
        <div class="modal-footer">
          <div class="col" align="center">
            <button type="button" class="btn btn-success" onclick="addCarrito()">Agregar al carrito</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal comprar -->
  <div class="modal fade  modal-centered" id="modalConfirmarCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5 w-100 text-center" id="tituloModalDetalle"><b>Confirmar compra</b></h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Contenido modal -->
          <form id="formNuevoViatico">
            <h5><i>Detalle de productos</i></h5>
            <table class="table table-striped">
              <thead>
                <tr style="text-align: center;">
                  <th>Logo</th>
                  <th>Producto</th>
                  <th>Tienda</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="contenidoTablaConfirmarCompra">
              </tbody>
            </table>
            <br>
            <div class="mb-3">
              <h5><i>Detalle de compra</i></h5>
            </div>
            <div class="mb-3">
              <span>▪️</span>
              <label class="form-label">&nbsp;&nbsp;Ciudad: </label>
              <label class="form-label" id="CiudadConfComp">Barranquilla</label>
            </div>
            <div class="mb-3">
              <span>▪️</span>
              <label class="form-label">&nbsp;&nbsp;Dirección: </label>
              <label class="form-label" id="dirConfComp">Cra 10 # 80 - 14</label>
            </div>
            <div class="mb-3" style="display: flex; align-items: center;">
              <span>▪️</span>
              <label class="form-label">&nbsp;&nbsp;Metodo de pago: </label>&nbsp;&nbsp;
              <select style="width: 250px;" class="form-select form-select-sm" aria-label="Small select example" id="metPagoConfComp">
                <option value="1" selected>Efectivo (Contra entrega)</option>
              </select>
            </div>
            <br>
            <div class="mb-3">
              <h5><i>Resumen</i></h5>
            </div>
            <div class="mb-3">
              <span>▪️</span>
              <label class="form-label">&nbsp;&nbsp;Subtotal: </label>
              <label class="form-label" id="subTotConfComp">$0</label>
            </div>
            <div class="mb-3">
              <span>▪️</span>
              <label class="form-label">&nbsp;&nbsp;Envío: </label>
              <label class="form-label">$10,000</label>
            </div>
            <div class="mb-3">
              <label class="form-label"><b>Total: </b></label>
              <label class="form-label" id="totConfComp"><b>$0</b></label>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <div class="col" align="center">
            <button type="button" class="btn btn-success" onclick="realizarPedido()">Realizar pedido</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
    include('footer.php');
    include('Js/home.js');
  ?>
</body>
</html>