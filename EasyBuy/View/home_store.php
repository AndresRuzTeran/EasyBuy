<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: inicio');
} else if ($_SESSION['tipo'] == 1) {
    header('Location: home');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="Img/Logo_sin_fondo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="proyect" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/inicio_store.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                            <li><a class="dropdown-item" onclick="logOut()">Salir</a></li>
                        </ul>
                    </div>

                </form>
            </div>
        </div>
    </nav>
    <br><br><br>

    <div class="container">
        <h1>Bienvenido al Administrador de <span id="nombre-store"></span> </h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="home" aria-selected="true">Productos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pedidos" type="button" role="tab" aria-controls="profile" aria-selected="false">
                    Pedidos
                    <span class="badge rounded-pill bg-info" id="spanTotPed"> 0</span>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Tab de productos -->
            <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="home-tab">
                <div class="mb-3 mt-3">
                    <button type="button" class="btn btn-secondary" onclick="openModalNewProduct(1,'')">Nuevo producto</button>
                </div>
                <table class="table table-striped" id="DtProducts">
                    <thead class="table-dark">
                        <tr style="text-align: center;">
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="gridProducts">
                    </tbody>
                </table>
            </div>
            <!-- Tab de pedidos -->
            <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="profile-tab">
                <div class="mt-3">
                    <table class="table table-striped" id="DtPedidos">
                        <thead class="table-light">
                            <tr style="text-align: center;">
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Ciudad</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo/editar Producto -->
    <div class="modal fade  modal-centered" id="modalNewProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5 w-100 text-center" id="tituloModalNewProduct">Nuevo producto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido modal -->
                    <input type="hidden" id="modalEditIdProduct" />
                    <form id="formNuevoProducto">
                        <div class="mb-3">
                            <label class="form-label"><b>Nombre:</b></label>
                            <input type="text" class="form-control" id="modalEditName" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un nombre.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Descripción:</b></label>
                            <textarea class="form-control" rows="3" id="modalEditDesc" required></textarea>
                            <div class="invalid-feedback">
                                Por favor ingrese una descripción.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Url imagen:</b></label>
                            <input type="text" class="form-control" id="modalEditUrl" onchange="actualizarImagen(this)" onfocus="document.getElementById('vpnp').hidden = true;" required>
                            <div class="invalid-feedback">
                                Por favor ingrese una url.
                            </div>
                            <span id="onErrorUrlInv">
                                <p style="color: red;">Por favor ingrese una url válida.</p>
                            </span>
                            <a onclick="event.preventDefault();this.nextElementSibling.hidden = !this.nextElementSibling.hidden;" href="">Vista previa</a>
                            <div class="text-center" id="vpnp">
                                <img class="img-thumbnail rounded" src="" alt="..." id="imgNewProduct" width="250px" onerror="this.src='Img/question.png';">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Precio:</b></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" min="1" id="modalEditPrecio" required>
                                <span class="input-group-text">.00</span>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingrese un precio válido
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Stock:</b></label>
                            <input type="number" class="form-control" min="1" id="modalEditStock" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un stock válido
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><b>Categoría:</b></label>
                            <select class="form-select" id="slcCategoria">
                            </select>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <div class="col" align="center">
                        <button type="button" class="btn btn-success" id="btnModalNewProduct" onclick="nuevoProducto()">Agregar</button>
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

    <!-- Modal act estado -->
    <div class="modal fade" id="modalActEstadoPed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Actualizar estado</h1>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="modalActEstIdProduct" />
                        <select class="form-select" id="slcEstado">
                            <option value="1">Pendiente</option>
                            <option value="2">Pagado</option>
                            <option value="3">Enviado</option>
                            <option value="4">Entregado</option>
                            <option value="5">Cancelado</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-4 col-sm-8">
                        <button type="button" class="btn btn-success" onclick="actStatusPed()">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include('footer.php');
    include('Js/home_store.js');
    ?>
</body>

</html>