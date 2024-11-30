<?php
        
    include('../../Model/Productos/ConsultarProductos.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $categoria = $data[0];
    $precio = $data[1];
    $nombre = $data[2];

    $filtro = "";

    if($categoria>=1){
        $filtro .= " Where a.categoria_id = '$categoria'";
    }else{
        $filtro .= " Where a.categoria_id is not null";
    }

    switch ($precio) {
        case 0:
            $filtro .= " AND a.precio > 1";
            break;
        case 1:
            $filtro .= " AND a.precio < 100000";
            break;
        case 2:
            $filtro .= " AND a.precio BETWEEN 100000 AND 500000";
            break;
        case 3:
            $filtro .= " AND a.precio BETWEEN 500000 AND 1000000";
            break;
        case 4:
            $filtro .= " AND a.precio > 1000000";
            break;
    }

    if (!empty($nombre)) {
        $filtro .= " AND a.nombre LIKE '%$nombre%'";
    }

    $consulta = consultar($filtro);
    $datos = [];

    while ($res = mysqli_fetch_assoc($consulta)) {
        if($res['estado'] == 1 && $res['stock'] >= 1){
            $datos[] = $res;
        }
    }
    

    // Devolver los resultados en formato JSON
    echo json_encode(["resultado" => true, "datos" => $datos]);

?>