<?php

    include('../../Model/Categorias/Consultar.php');
    $consulta = consultar(null);
    $datos = [];

    while ($res = mysqli_fetch_assoc($consulta)) {
        $datos[] = $res;
    }

    // Devolver los resultados en formato JSON
    echo json_encode(["resultado" => true, "datos" => $datos]);

?>