<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  

<script>
    var modalNewProduct = bootstrap.Modal.getOrCreateInstance('#modalNewProduct');
    var modalSuccess = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalError = bootstrap.Modal.getOrCreateInstance('#modalError');
    var modalFactura = bootstrap.Modal.getOrCreateInstance('#modalFactura');
    var modalActEstadoPed = bootstrap.Modal.getOrCreateInstance('#modalActEstadoPed');
    let store = "";

    window.addEventListener('load', ()=>{
        cargarInfoUser();
        cargarInfoProducts();
        cargarInfoPedidos();
        cargarInfoCat();
        document.getElementById('registro-vend-footer').hidden = true;
        document.getElementById('pqr-footer').hidden = true;
    });

    function cargarInfoUser(){
        fetch('Controller/store/readInfo.php')
        .then(response => response.json())
        .then(data => {
            store = data.datos.nombre;
            document.getElementById('nombre-store').innerHTML = "<b>"+data.datos.nombre+"</b>";
        })
        .catch(error => console.error('Error al cargar información del usuario:', error));
    }

    function cargarInfoCat(){
        fetch('Controller/Categoria/getCategorias.php')
        .then(response => response.json())
        .then(data => {
            {/* <option value="">Selecciona una categoría</option> */}
            let selectCatFiltro = document.getElementById("slcCategoria");
            selectCatFiltro.innerHTML = "";
            let contenido = '';
            if(data.datos.length >= 1){
                data.datos.forEach(row=>{
                    if(row['estado']=1){
                        contenido += '<option value="'+row['id']+'">'+row['nombre']+'</option>';
                    }
                });
            }
            selectCatFiltro.innerHTML = contenido;
        })
        .catch(error => console.error('Error al cargar categorias:', error));
    }


    function cargarInfoProducts(){
        fetch('Controller/Producto/getProductoByStore.php')
        .then(response => response.json())
        .then(data => {
            let tableContent = [];
            if(data.datos.length >= 1){
                data.datos.forEach(row=>{
                    let estado = "";
                    if(row['estado'] == 1){
                        estado = '<span class="badge badge-pill badge-success">Activo</span>';
                    }else{
                        estado = '<span class="badge badge-pill badge-danger">Inactivo</span>';
                    }
                    let acciones = `
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="Img/wheel.png" alt="Opciones" style="width:20px; height:20px;">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#" data-row=\'` + JSON.stringify(row) + `\' onclick="openModalNewProduct(2,this)">Editar</a></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="changeStatusProduct(`+row['id']+`,`+row['estado']+`)">`+(row['estado'] == 1?"Inactivar":"Activar")+`</a>
                                </li>
                            </ul>
                        </div>`;

                    tableContent.push([
                        row['id'], row['nombre'], row['descripcion'], convertToMoneda(parseInt(row['precio'])), row['stock'],
                        row['categoria'], estado, acciones
                    ]);

                });
            }else{
                console.log('No hay productos para mostrar');
            }

            if($.fn.DataTable.isDataTable('#DtProducts')) {
                var tablePro = $('#DtProducts').DataTable();
                tablePro.clear().rows.add(tableContent).draw();
            } else {
                $('#DtProducts').DataTable({
                    scrollX: true, 
                    autoWidth: false,
                    responsive: true,
                    data: tableContent,
                    language: {
                        url: 'Assets/es-ES.json',
                        search: "Buscador:",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: ">",
                            previous: "<"
                        }
                    }
                });
            }
        })
        .catch(error => console.error('Error al cargar los productos:', error));
    }

    function cargarInfoPedidos(){
        fetch('Controller/Pedidos/misPedidos.php')
        .then(response => response.json())
        .then(data => {
            let tableContent = [];
            let numDatos = data.datos.length;
            if(numDatos >= 1){
                data.datos.forEach(row=>{
                    let estado = "";
                    switch (row['estado']) {
                        case 'pagado':
                            estado = '<span class="badge badge-pill badge-warning text-dark">Pagado</span>';
                            break;
                        
                        case 'enviado':
                            estado = '<span class="badge badge-pill badge-info">Enviado</span>';
                            break;
                    
                        case 'entregado':
                            estado = '<span class="badge badge-pill badge-success">Entregado</span>';
                            break;
                    
                        case 'cancelado':
                            estado = '<span class="badge badge-pill badge-danger">Cancelado</span>';
                            break;
                    
                        default:
                            estado = '<span class="badge badge-pill badge-secondary">Pendiente</span>';
                            break;
                    }
                    let acciones = `
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="Img/wheel.png" alt="Opciones" style="width:20px; height:20px;">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop1">
                                <li>
                                    <a class="dropdown-item" href="#" data-row=\'` + JSON.stringify(row) + `\' onclick="openFactura(this)">Ver factura/Detalle</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="loadModalStatus(`+row['id']+`,'`+row['estado']+`')">Actualizar estado</a>
                                </li>
                            </ul>
                        </div>`;

                    tableContent.push([
                        row['id'], row['fecha_pedido'], row['ciudad'], row['nombre'], row['cantidad'],
                        convertToMoneda(parseInt(row['precio'])*parseInt(row['cantidad'])), estado, acciones
                    ]);

                });
            }else{
                console.log('No hay productos para mostrar');
            }

            document.getElementById('spanTotPed').innerHTML = numDatos;
            
            if($.fn.DataTable.isDataTable('#DtPedidos')) {
                var tablePro = $('#DtPedidos').DataTable();
                tablePro.clear().rows.add(tableContent).draw();
            } else {
                $('#DtPedidos').DataTable({
                    scrollX: true, 
                    autoWidth: false,
                    responsive: true,
                    data: tableContent,
                    language: {
                        url: 'Assets/es-ES.json',
                        search: "Buscador:",
                        paginate: {
                            first: "Primero",
                            last: "Último",
                            next: ">",
                            previous: "<"
                        }
                    }
                });
            }
        })
        .catch(error => console.error('Error al cargar los pedidos:', error));
    }

    function openModalNewProduct(tipo,button){
        let form = document.getElementById('formNuevoProducto');
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('vpnp').hidden = true;
        document.getElementById('onErrorUrlInv').hidden = true;
        if(tipo == 1){
            document.getElementById('tituloModalNewProduct').innerHTML = "Nuevo producto";
            document.getElementById('imgNewProduct').src = "";
            document.getElementById('modalEditIdProduct').value = 0;
            document.getElementById('modalEditName').focus();
        }else{
            let datos = JSON.parse(button.dataset.row);
            document.getElementById('tituloModalNewProduct').innerHTML = "Editar producto";
            let nombre = document.getElementById('modalEditName');
            nombre.value = datos.nombre;
            nombre,focus();
            document.getElementById('modalEditDesc').value = datos.descripcion;
            document.getElementById('modalEditUrl').value = datos.imagen_url;
            document.getElementById('imgNewProduct').src = datos.imagen_url;
            document.getElementById('modalEditPrecio').value = parseInt(datos.precio);
            document.getElementById('modalEditStock').value = datos.stock;
            document.getElementById('slcCategoria').value = datos.categoria_id;
            document.getElementById('modalEditIdProduct').value = datos.id;
        }
        modalNewProduct.show();
    }

    function nuevoProducto(){
        event.preventDefault();
        let form = document.getElementById('formNuevoProducto');
        form.classList.add('was-validated');

        if (form.checkValidity()) {
            var data = [];
            form.querySelectorAll("input, select, textarea, img").forEach(function(element) {
                if (element.tagName.toLowerCase() === "img") {
                    data.push(element.src);
                } else {
                    data.push(element.value);
                }
            });
            if (data[3] && data[3].includes("question.png")) {
                document.getElementById('vpnp').hidden = true;
                document.getElementById('onErrorUrlInv').hidden = false;
            }else {
                let idProduct = document.getElementById('modalEditIdProduct').value;
                document.getElementById('onErrorUrlInv').hidden = true;
                if(idProduct == 0){
                    fetch('Controller/Producto/nuevoProducto.php', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(res => {
                        modalNewProduct.hide();
                        if(res.resultado){
                            document.getElementById('mensajeSuccess').innerHTML = res.mensaje;
                            modalSuccess.show();
                            cargarInfoProducts();
                        }else{
                            document.getElementById('mensajeError').innerHTML = res.mensaje;
                            modalError.show();
                        }
                    })
                    .catch(error => console.error('Error al cargar los productos:', error));
                }else{
                    data.push(idProduct);
                    fetch('Controller/Producto/actualizar_producto.php', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(res => {
                        modalNewProduct.hide();
                        if(res.resultado){
                            document.getElementById('mensajeSuccess').innerHTML = res.mensaje;
                            modalSuccess.show();
                            cargarInfoProducts();
                        }else{
                            document.getElementById('mensajeError').innerHTML = res.mensaje;
                            modalError.show();
                        }
                    })
                    .catch(error => console.error('Error al cargar los productos:', error));
                }
                
            }
        }
    }

    function changeStatusProduct(id,status){
        fetch('Controller/Producto/actualizar_estado.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify([id,status])
        })
        .then(response => response.json())
        .then(res => {
            if(!res.resultado){
                document.getElementById('mensajeError').innerHTML = res.mensaje;
                modalError.show();
            }
            cargarInfoProducts();
        })
        .catch(error => console.error('Error al cargar los productos:', error));
    }

    function openFactura(button) {
        let datos = JSON.parse(button.dataset.row);
        document.getElementById('fact-id').innerHTML = datos.id;
        document.getElementById('fact-fecha').innerHTML = datos.fecha_pedido;
        document.getElementById('fact-cli').innerHTML = datos.nombre_usuario+" "+datos.apellido_usuario;
        document.getElementById('fact-store').innerHTML = store;
        document.getElementById('fact-ciudad').innerHTML = datos.ciudad;
        document.getElementById('fact-direccion').innerHTML = datos.direccion;
        document.getElementById('fact-metodo').innerHTML = datos.nombre_metodo;
        document.getElementById('fact-estado').innerHTML = datos.estado;
        //Tabla de produto
        document.getElementById('fact-nombre').innerHTML = datos.nombre;
        document.getElementById('fact-cant').innerHTML = datos.cantidad;
        document.getElementById('fact-precio').innerHTML = convertToMoneda(parseInt(datos.precio));
        const total = convertToMoneda(parseInt(datos.precio)*datos.cantidad);
        document.getElementById('fact-total1').innerHTML = total;
        document.getElementById('fact-total2').innerHTML = total;
        modalFactura.show();
    }

    function imprimirFactura() {
        const modalContent = document.querySelector("#modalFactura .modal-body").innerHTML;

        const printWindow = window.open("", "_blank", "width=800,height=600");

        printWindow.document.write(`
            <html>
            <head>
                <title>Factura</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .invoice-container {
                        margin: 20px auto;
                        max-width: 600px;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    }
                    .invoice-header {
                        text-align: center;
                    }
                    .invoice-details, .invoice-items {
                        width: 100%;
                        margin: 20px 0;
                        border-collapse: collapse;
                    }
                    .invoice-details td, .invoice-items th, .invoice-items td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    .invoice-items th {
                        background-color: #f4f4f4;
                    }
                    .invoice-total {
                        font-weight: bold;
                        background-color: #f4f4f4;
                    }
                    .text-center {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                ${modalContent}
            </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.print();

        printWindow.onafterprint = function () {
            printWindow.close();
        };
    }

    function loadModalStatus(id,estado){
        let id_estado = 0;
        switch (estado) {
            case 'pagado':
                id_estado = 2;
                break;
            
            case 'enviado':
                id_estado = 3;
                break;
        
            case 'entregado':
                id_estado = 4;
                break;
        
            case 'cancelado':
                id_estado = 5;
                break;
        
            default:
                id_estado = 1;
                break;
        }
        document.getElementById('modalActEstIdProduct').value = id;
        document.getElementById('slcEstado').value = id_estado;
        modalActEstadoPed.show();
    }

    function actStatusPed(){
        modalActEstadoPed.hide();
        fetch('Controller/Pedidos/actualizar_estado.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify([document.getElementById('modalActEstIdProduct').value,document.getElementById('slcEstado').value])
        })
        .then(response => response.json())
        .then(res => {
            if(!res.resultado){
                document.getElementById('mensajeError').innerHTML = res.mensaje;
                modalError.show();
            }
            cargarInfoPedidos();
        })
        .catch(error => console.error('Error al cargar los productos:', error));
        
    }

    function logOut(){
        fetch('Controller/session/close.php')
        .then(response => response.json())
        .then(data => {
            var link = document.createElement('a');
            link.href = 'inicio';
            link.id = 'linkURL';
            document.body.appendChild(link);
            document.getElementById("linkURL").click();
        })
        .catch(error => console.error('Error al actualizar la sesión:', error));
    }

    function convertToMoneda(valor){
        return '$' + valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function actualizarImagen(input) {
        const valor = input.value.trim();
        const url = valor.startsWith("http") ? valor : "";
        document.getElementById('imgNewProduct').src = url;
    }


</script>