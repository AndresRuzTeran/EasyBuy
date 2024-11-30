<?php

    function actualizar_status($ped,$status){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $status, $ped);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>