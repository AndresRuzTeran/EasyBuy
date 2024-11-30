<?php

    function consultar($id){
        include_once('../../Model/bd.php');
        $con = connection();
        $sql = "SELECT * FROM users where id = '$id'";
        $query = mysqli_query($con,$sql);
        return $query;
    }
    

?>