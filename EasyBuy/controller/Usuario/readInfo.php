<?php
    session_start();

    include('../../Model/Usuarios/Consultar_id.php');
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $consulta = consultar($id);
        $res = mysqli_fetch_assoc($consulta);
        echo json_encode(["resultado" => true ,"datos" => $res]);
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Error, no está loggeado"]);
    }

?>