<?php

    function actualizar_product($id,$idPro,$nombre,$descrip,$precio,$stock,$cat,$url){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?, imagen_url = ? WHERE id = ? and store_id = ?;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sssiisii', $nombre,$descrip,$precio,$stock,$cat,$url, $idPro, $id);
        $query = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $query;
    }
    

?>