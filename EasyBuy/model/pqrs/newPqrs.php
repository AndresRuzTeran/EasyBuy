<?php

    function insertar($id_usuario,$tipo,$asunto,$desc){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "INSERT INTO pqrs (usuario_id, tipo, asunto, descripcion) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iiss', $id_usuario, $tipo, $asunto, $desc);
            mysqli_stmt_execute($stmt);
            $last_id = mysqli_insert_id($con);
            mysqli_stmt_close($stmt);
            return $last_id;
        }else{
            return false;
        }
    }

?>