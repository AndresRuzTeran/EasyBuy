<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var modalSuccess = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalError = bootstrap.Modal.getOrCreateInstance('#modalError');
    var modalFactura = bootstrap.Modal.getOrCreateInstance('#modalFactura');
    let nameUser = "";

    {/* Primera accion */}
    window.addEventListener('load', ()=>{
        document.getElementById('registro-vend-footer').hidden = true;
        cargarInfoUser();
        loadHistPedidos();
    });

    function cargarInfoUser(){
        fetch('Controller/Usuario/readInfo.php')
        .then(response => response.json())
        .then(data => {
            let info = data.datos;
            document.getElementById('name').value = info.nombre;
            document.getElementById('lastname').value = info.apellido;
            nameUser = info.nombre+" "+info.apellido;
            document.getElementById('email').value = info.correo;
            document.getElementById('phone').value = info.celular;
            document.getElementById('city').value = info.ciudad;
            document.getElementById('direccion').value = info.direccion;
        })
        .catch(error => console.error('Error al cargar información del usuario:', error));
    }

    function actDatos(){
        event.preventDefault();
        let form = document.getElementById('formActDatos');
        form.classList.add('was-validated');

        if (form.checkValidity()) {
            var data = [];
            form.querySelectorAll("input, select").forEach(function(element) {
                data.push(element.value);
            });
            fetch("Controller/Usuario/actualizar.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if(res.resultado){
                    document.getElementById('mensajeSuccess').innerHTML = res.mensaje;
                    modalSuccess.show();
                    form.classList.remove('was-validated');
                }else{
                    document.getElementById('mensajeError').innerHTML = res.mensaje;
                    modalError.show();
                }
            })
            .catch(error => console.error(error)); 
        }
    }

    function cambiarPass(){
        event.preventDefault();
        let form = document.getElementById('formActPass');
        form.classList.add('was-validated');

        if (form.checkValidity()) {
            var data = [];
            form.querySelectorAll("input").forEach(function(element) {
                data.push(element.value);
            });
            fetch("Controller/Usuario/actualizar_pass.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if(res.resultado){
                    document.getElementById('mensajeSuccess').innerHTML = res.mensaje;
                    modalSuccess.show();
                    form.classList.remove('was-validated');
                }else{
                    document.getElementById('mensajeError').innerHTML = res.mensaje;
                    modalError.show();
                    form.reset();
                }
            })
            .catch(error => console.error(error));
        }
    }

    function loadHistPedidos(){
        fetch('Controller/Pedidos/historial_pedidos.php')
        .then(response => response.json())
        .then(data => {
            let tablaConfirmarCompra = document.getElementById('contTablaHistComp');
            let contenido = "";
            if(data.resultado && data.datos.length >= 1){
                data.datos.forEach(row => {
                    contenido += '<tr><td>'+row.fecha_pedido+'</td>';
                    contenido += '<td>'+row.nombre+'</td>';
                    contenido += '<td>'+convertToMoneda(row.cantidad*row.precio)+'</td>';
                    contenido += '<td>'+row.estado+'</td>';
                    contenido += '<td align="center"><button class="btn btn-link" data-row=\'' + JSON.stringify(row) + '\' onclick="detallePedido(this)"><i class="bi bi-eye"></i></button></td></tr>';
                });
            }else{
                contenido = '<h6 align="center">No tiene compras registradas</h6>';
            }
            tablaConfirmarCompra.innerHTML = contenido;
        })
        .catch(error => console.error('Error al traer los pedidos:', error));
    }

    function detallePedido(button) {
        let datos = JSON.parse(button.dataset.row);
        document.getElementById('fact-id').innerHTML = datos.id;
        document.getElementById('fact-fecha').innerHTML = datos.fecha_pedido;
        document.getElementById('fact-cli').innerHTML = nameUser;
        document.getElementById('fact-store').innerHTML = datos.store;
        document.getElementById('fact-ciudad').innerHTML = datos.ciudad;
        document.getElementById('fact-direccion').innerHTML = datos.direccion;
        document.getElementById('fact-metodo').innerHTML = datos.nombre_metodo;
        document.getElementById('fact-estado').innerHTML = datos.estado;
        //Tabla de produto
        document.getElementById('fact-nombre').innerHTML = datos.nombre;
        document.getElementById('fact-cant').innerHTML = datos.cantidad;
        document.getElementById('fact-precio').innerHTML = parseInt(datos.precio);
        const total = convertToMoneda(parseInt(datos.precio)*datos.cantidad);
        document.getElementById('fact-total1').innerHTML = total;
        document.getElementById('fact-total2').innerHTML = total;
        modalFactura.show();
    }

    function imprimirFactura() {
        // Seleccionar el contenido del modal que se quiere imprimir
        const modalContent = document.querySelector("#modalFactura .modal-body").innerHTML;

        // Crear una nueva ventana para imprimir
        const printWindow = window.open("", "_blank", "width=800,height=600");

        // Crear el contenido HTML para la ventana de impresión
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

        // Esperar a que cargue el contenido y luego imprimir
        printWindow.document.close();
        printWindow.print();

        // Cerrar la ventana después de imprimir
        printWindow.onafterprint = function () {
            printWindow.close();
        };
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
</script>