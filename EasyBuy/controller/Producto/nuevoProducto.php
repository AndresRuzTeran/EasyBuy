<?php
    session_start();

    include('../../Model/Productos/newProduct.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $nombre = $data[0];
    $descrip = $data[1];
    $precio = $data[4];
    $stock = $data[5];
    $cat = $data[6];
    $url = $data[2];
    $store = $_SESSION['id'];
    $estado = 1;

    $query = insertar_product($nombre,$descrip,$precio,$stock,$cat,$url,$store, $estado);

    if($query){
        echo json_encode(["resultado" => true, "mensaje" => "Producto agregado correctamnete"]);
    }else{
        echo json_encode(["resultado" => false, "mensaje" => "Error al agregar el producto"]);
    }    

?>