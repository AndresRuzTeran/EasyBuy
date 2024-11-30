<?php

    function insertar_product($name,$desc,$precio,$stock,$cat,$url,$store,$estado){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen_url, store_id,estado) VALUES (?, ?, ?, ?, ?, ?, ?,?);";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sssiisii', $name,$desc,$precio,$stock,$cat,$url,$store,$estado);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>