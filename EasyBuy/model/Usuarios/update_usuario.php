<?php

    function actualizar($id,$name,$lastname,$correo,$cell,$ciudad,$dir){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "UPDATE users SET nombre = ?, apellido = ?, correo = ?, celular = ?, ciudad = ?, direccion = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssi', $name,$lastname,$correo,$cell,$ciudad,$dir, $id);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>