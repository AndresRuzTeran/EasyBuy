<?php

    session_start();

    include('../../Model/Productos/updateProduct.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $idPro = $data[7];
    $nombre = $data[0];
    $descrip = $data[1];
    $precio = $data[4];
    $stock = $data[5];
    $cat = $data[6];
    $url = $data[2];

    $query = actualizar_product($id,$idPro,$nombre,$descrip,$precio,$stock,$cat,$url);

    if($query){
        echo json_encode(["resultado" => true ,"mensaje" => "Se ha actualizado el producto"]);
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Error al actualizar el producto"]);
    }

?>