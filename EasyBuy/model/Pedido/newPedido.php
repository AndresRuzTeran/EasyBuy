<?php

    function insertarPedido($id_usuario,$metodoPago,$id_producto,$cantidad,$precio){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "INSERT INTO pedidos (usuario_id,metodoPago_id,producto_id,cantidad,precio) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'iiiid', $id_usuario,$metodoPago,$id_producto,$cantidad,$precio);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;        
    }


?>