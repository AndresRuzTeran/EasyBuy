<?php

    function insertar($name,$nit,$correo,$cell,$pass,$ciudad,$dir,$est){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "INSERT INTO store(nombre,nit,correo,celular,pass,ciudad,direccion,estado) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssi', $name,$nit,$correo,$cell,$pass,$ciudad,$dir,$est);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>