<?php
    session_start();

    include('../../Model/Pedido/consulta_pedido_idStore.php');

    $id = $_SESSION['id'];

    $consulta = consultar($id);

    $datos = [];

    while ($res = mysqli_fetch_assoc($consulta)) {
        $datos[] = $res;
    }

    echo json_encode(["resultado" => true, "datos" => $datos]);

?>