<?php

    function actualizar_status($id,$pro,$status){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "UPDATE productos SET estado = ? WHERE id = ? and store_id = ?;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $status, $pro, $id);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>