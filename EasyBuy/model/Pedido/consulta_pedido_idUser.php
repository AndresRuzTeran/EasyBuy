<?php

    function consultar($id){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT a.fecha_pedido, a.id, a.cantidad, a.precio, a.estado, a.ciudad, a.direccion, b.nombre_metodo, c.nombre, c.imagen_url, d.nombre as 'store' FROM pedidos a inner join metodo_pago b on a.metodoPago_id = b.id inner join productos c on a.producto_id = c.id inner join store d on c.store_id = d.id where a.usuario_id = $id;";
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>