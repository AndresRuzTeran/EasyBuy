<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    {/* Modales */}
    var modalDetalleProduct = bootstrap.Modal.getOrCreateInstance('#modalDetalleProduct');
    var modalSuccess = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalConfirmarCompra = bootstrap.Modal.getOrCreateInstance('#modalConfirmarCompra');

    {/* Almacenamiento temporal */}
    var carritoLocal;

    {/* Primera accion */}
    window.addEventListener('load', ()=>{
        document.getElementById('registro-vend-footer').hidden = true;
        cargarInfoUser();
        cargarInfoCat();
        cargarInfoProducts();
        loadCarrito();
    });

    function cargarInfoUser(){
        fetch('Controller/Usuario/readInfo.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('saludo').innerHTML = "Bienvenid@ <b>"+data.datos.nombre+"</b><br> Estos son los productos Disponibles";
            document.getElementById('CiudadConfComp').innerHTML = data.datos.ciudad;
            document.getElementById('dirConfComp').innerHTML = data.datos.direccion;
        })
        .catch(error => console.error('Error al cargar información del usuario:', error));
    }

    function cargarInfoCat(){
        fetch('Controller/Categoria/getCategorias.php')
        .then(response => response.json())
        .then(data => {
            let selectCatFiltro = document.getElementById("slcCategoria");
            selectCatFiltro.innerHTML = "";
            let contenido = '<option value="0" selected>Todas</option>';
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
        event.preventDefault();
        //Obtenemos los filtros
        let form = document.getElementById('filtros');
        var dataFiltros = [];
        form.querySelectorAll("input, select").forEach(function(element) {
            dataFiltros.push(element.value);
        });

        fetch('Controller/Producto/getProductos.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dataFiltros)
        })
        .then(response => response.json())
        .then(data => {
            let grid = document.getElementById("gridProducts");
            grid.innerHTML = "";
            let contenido = "";
            if(data.datos.length >= 1){
                data.datos.forEach(row=>{
                    contenido += '<div class="product-card"><img src="'+row['imagen_url']+'" alt="Nombre del Producto">';
                    contenido += '<div class="product-info"><h2>'+row['nombre']+'</h2>';
                    contenido += '<p class="price">'+convertToMoneda(row['precio'])+'</p>';
                    contenido += '<p class="description">'+recortarTexto(row['descripcion'], 50)+'</p>';
                    contenido += '</div><div class="product-overlay"><p class="full-description">'+row['descripcion']+'</p>';
                    contenido += '<button class="detalle-button" onclick="openDetalleProduct('+row['id']+')">Ver detalles</button></div></div>';
                });
            }else{
                contenido += '<h3>No hay productos para mostrar</3>';
            }
            grid.innerHTML = contenido;

        })
        .catch(error => console.error('Error al cargar los productos:', error));
    }

    function openDetalleProduct(id){
        fetch('Controller/Producto/getProductoById.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`,
          })
        .then(response => response.json())
        .then(data => {
            var datosProduct = data.datos[0];
            document.getElementById('idProductModalDetalle').value = datosProduct.id;
            document.getElementById('tituloModalDetalle').innerHTML = "Detalle de <b>"+(datosProduct.nombre)+"</b>";
            document.getElementById('imgModalDetalle').src = datosProduct.imagen_url;
            document.getElementById('descModalDetalle').innerHTML = datosProduct.descripcion;
            document.getElementById('precioModalDetalle').innerHTML = convertToMoneda(datosProduct.precio);
            document.getElementById('catModalDetalle').innerHTML = datosProduct.categoria;
            let spinner = document.getElementById('spinerModalDetalle');
            spinner.max = parseInt(datosProduct.stock);
            spinner.value = 1;
            modalDetalleProduct.show();
        })
        .catch(error => console.error('Error al cargar lel detalle del producto:', error));
    }

    function addCarrito(){
        var data = [];
        let id = document.getElementById('idProductModalDetalle').value;
        let cantidad =  document.getElementById('spinerModalDetalle').value;
        data.push(id);
        data.push(cantidad);
        fetch('Controller/cookies/addProduct.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            loadCarrito();
            modalDetalleProduct.hide();
            document.getElementById('mensajeSuccess').innerHTML = "Producto añadido al carrito";
            modalSuccess.show();

        })
        .catch(error => console.error('Error al cargar los productos al caarrito:', error));
    }

    function loadCarrito(){
        fetch('Controller/cookies/loadProduct.php')
        .then(response => response.json())
        .then(data => {
            let tablaCarrito = document.getElementById("contenidoCarrito");
            let totalCarritoFinal = document.getElementById("totalCarritoFinal");
            let spanCarrito = document.getElementById('spanCarrito');
            let pagarAhoraCart = document.getElementById('pagarAhoraCart');
            tablaCarrito.innerHTML = "";
            let contenido = "";
            let totalCarrito = 0;
            let cont=0;

            if(data.resultado && data.datos.length >= 1){
                carritoLocal = data.datos;
                loadTablaConfCompra();
                totalCarritoFinal.hidden = false;
                spanCarrito.hidden = false;
                pagarAhoraCart.hidden = false;
                data.datos.forEach(row=>{
                    contenido += '<tr ><td><img class="img-fluid rounded" style="max-height: 90px; width: auto;" src="'+row['imagen_url']+'"></td>';
                    contenido += '<td>'+row['nombre']+'</td>';
                    contenido += '<td>'+convertToMoneda(parseInt(row['precio']))+'</td><td>';
                    contenido += '<div class="input-group"><button class="btn btn-outline-secondary btn-sm" onclick="decrementQuantity('+row['id']+',this)">-</button>';
                    contenido += '<input type="number" class="form-control form-control-sm text-center" value="'+row['cantidad']+'" max="'+row['stock']+'" name="cartSpinner" >';
                    contenido += '<button class="btn btn-outline-secondary btn-sm" onclick="incrementQuantity('+row['id']+',this)">+</button>';
                    let total = parseFloat(row['precio'])*parseInt(row['cantidad']);
                    contenido += '</div></td><td>'+convertToMoneda(total)+'</td>';
                    contenido += '<td><button type="button" class="btn btn-light" onclick="deleteCart('+row['id']+')"><img src="Img/trash.png" alt="Eliminar" style="width:20px; height:20px;"></button></td></tr>';
                    totalCarrito += total;
                    cont++;
                });
            }else{
                contenido += '<h6 align="center">El carrito está vacío</h6>';
                totalCarritoFinal.hidden = true;
                spanCarrito.hidden = true;
                pagarAhoraCart.hidden = true;
            }
            tablaCarrito.innerHTML = contenido;
            totalCarritoFinal.innerHTML = 'Total: '+convertToMoneda(totalCarrito);
            spanCarrito.innerHTML = cont;
        })
        .catch(error => console.error('Error al cargar el carrito:', error));
    }

    function loadTablaConfCompra(){
        let tablaConfirmarCompra = document.getElementById('contenidoTablaConfirmarCompra');
        let subTotConfComp = document.getElementById('subTotConfComp');
        let totConfComp = document.getElementById('totConfComp');
        let contenido = "";
        let subTot = 0;
        let envio = 10000;
        carritoLocal.forEach(row=>{
            contenido += '<tr style="text-align: center;"><td><img class="img-fluid rounded" style="max-height: 80px; width: auto;" src="'+row['imagen_url']+'"></td>';
            contenido += '<td>'+row['nombre']+'</td>';
            contenido += '<td>'+row['store']+'</td>';
            contenido += '<td>'+convertToMoneda(parseInt(row['precio']))+'</td>';
            contenido += '<td>'+row['cantidad']+'</td>';
            let total = parseFloat(row['precio'])*parseInt(row['cantidad']);
            subTot += total;
            contenido += '<td>'+convertToMoneda(total)+'</td></tr>';
        });
        tablaConfirmarCompra.innerHTML = contenido;
        subTotConfComp.innerHTML = convertToMoneda(subTot);
        totConfComp.innerHTML = "<b>"+convertToMoneda(subTot+envio)+"</b>";
    }

    function deleteCart(id){
        fetch('Controller/cookies/deleteProduct.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`,
          })
        .then(response => response.json())
        .then(data => {
            loadCarrito();
        })
        .catch(error => console.error('Error al eliminar los productos del carrito:', error));
    }

    function editCart(id,cantidad){
        var data = [id,cantidad];
        fetch('Controller/cookies/editProduct.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            loadCarrito();
        })
        .catch(error => console.error('Error al editar los productos del carrito:', error));
    }

    function openModalCompra(){
        document.getElementById('buttonCarrito').click();
        modalConfirmarCompra.show();
    }

    function realizarPedido(){
        let total = document.getElementById('totConfComp').innerHTML.replace(/<\/?[^>]+(>|$)/g, "").replace(/[.$]/g, "");
        var datos = [total,carritoLocal,document.getElementById('metPagoConfComp').value];
        fetch('Controller/Pedidos/nuevoPedido.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(res => {
            vaciarCarrito();
            modalConfirmarCompra.hide();
            document.getElementById('mensajeSuccess').innerHTML = res.mensaje;
            modalSuccess.show();
        })
        .catch(error => console.error('Error al realizar pedido:', error));
    }

    function vaciarCarrito(){
        fetch('Controller/cookies/vaciarCarrito.php')
        .then(response => response.json())
        .then(data => {
            loadCarrito();
        })
        .catch(error => console.error('Error al vaciar carrito:', error));
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

    function recortarTexto(texto, maxCaracteres) {
        if (texto.length > maxCaracteres) {
            return texto.substring(0, maxCaracteres) + '...';
        } else {
            return texto;
        }
    }

    function decrementQuantity(id,button){
        const input = button.nextElementSibling;
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            if(input.name == "cartSpinner"){
                editCart(id,input.value);
            }
        }
    }
    function incrementQuantity(id,button){
        const input = button.previousElementSibling;
        if(parseInt(input.value) < parseInt(input.max)){
            input.value = parseInt(input.value) + 1;
            if(input.name == "cartSpinner"){
                editCart(id,input.value);
            }
        }
    }

</script>