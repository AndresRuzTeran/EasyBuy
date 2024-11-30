<?php

    include('../../Model/Pedido/updateStatus.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $idPed = $data[0];
    $status = $data[1];

    $query = actualizar_status($idPed,$status);

    if($query){
        echo json_encode(["resultado" => true ,"mensaje" => "Se ha actualizado el estado del pedido"]);
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Error al actualizar el estado del pedido"]);
    }

?>