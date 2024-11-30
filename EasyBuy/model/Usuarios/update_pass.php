<?php

    function actualizar($id,$pass){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "UPDATE users SET pass = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $pass,$id);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>