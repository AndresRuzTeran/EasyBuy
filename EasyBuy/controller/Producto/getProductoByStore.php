<?php
    session_start();

    include('../../Model/Productos/ConsultarProductos.php');

    $id_store = $_SESSION['id'];

    $consulta = consultar(" Where a.store_id = $id_store");
    $datos = [];

    while ($res = mysqli_fetch_assoc($consulta)) {
        $datos[] = $res;
    }

    // Devolver los resultados en formato JSON
    echo json_encode(["resultado" => true, "datos" => $datos]);

?>