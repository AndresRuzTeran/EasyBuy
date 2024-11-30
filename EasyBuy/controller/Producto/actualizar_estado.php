<?php

    session_start();

    include('../../Model/Productos/updateStatus.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $idPro = $data[0];
    $status = $data[1] ==1?0:1;

    $query = actualizar_status($id,$idPro,$status);

    if($query){
        echo json_encode(["resultado" => true ,"mensaje" => "Se ha actualizado el estado del producto"]);
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Error al actualizar el estado del producto"]);
    }

?>