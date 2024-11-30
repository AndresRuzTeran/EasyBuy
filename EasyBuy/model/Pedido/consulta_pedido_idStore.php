<?php

    function consultar($id){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT a.fecha_pedido, a.id, a.cantidad, a.precio, a.estado, a.ciudad, a.direccion, b.nombre_metodo, c.nombre, c.imagen_url, d.nombre as 'nombre_usuario', d.apellido as 'apellido_usuario' FROM pedidos a inner join metodo_pago b on a.metodoPago_id = b.id inner join productos c on a.producto_id = c.id inner join users d on a.usuario_id = d.id where c.store_id = $id;";
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>