<?php

    function consultar($filtro){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT a.id, a.nombre, a.descripcion, a.precio, a.stock, a.categoria_id, a.imagen_url, a.estado, b.nombre as 'categoria', c.nombre as 'store' FROM productos a inner join categorias b on a.categoria_id = b.id inner join store c on a.store_id = c.id ".($filtro ? $filtro : "");
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>