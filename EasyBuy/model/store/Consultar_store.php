<?php

    function consultar_store($correo){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT * FROM store where correo = '$correo'";
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>