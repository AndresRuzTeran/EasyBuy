<?php
    session_start();

    include('../../Model/Pedido/newPedido.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $total = $data[0];
    $productos = $data[1];
    $metodoPago = $data[2];

    foreach($productos as $producto){
        insertarPedido($id,$metodoPago,$producto['id'],$producto['cantidad'],$producto['precio']);
    }

    // Devolver los resultados en formato JSON
    echo json_encode(["resultado" => true, "mensaje" => "¡Gracias por tu compra!<br>Se ha registrado el pedido"]);

?>