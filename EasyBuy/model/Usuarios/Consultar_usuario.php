<?php

    function consultar($correo){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT * FROM users where correo = '$correo'";
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>