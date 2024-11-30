<?php

    include('../../Model/Productos/ConsultarProductos.php');

    $id = $_POST['id'];

    $consulta = consultar(" Where a.id = $id");
    $datos = [];

    while ($res = mysqli_fetch_assoc($consulta)) {
        $datos[] = $res;
    }

    // Devolver los resultados en formato JSON
    echo json_encode(["resultado" => true, "datos" => $datos]);

?>