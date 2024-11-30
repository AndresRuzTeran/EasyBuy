<?php
    session_start();    
    include('../../Model/Productos/ConsultarProductos.php');
    $nameCookie = 'cart-'.$_SESSION['id'];

    //Verifica cookies
    if(isset($_COOKIE[$nameCookie])) {
        $datos = json_decode($_COOKIE[$nameCookie], true);
        $filtro = " where ";
        //Se arma el where
        foreach ($datos as $key => $producto) {
            if ($key > 0) {
                $filtro .= " or ";
            }
            $filtro .= "a.id=" . $producto[0];
        }
        //Ejecuta la consulta
        $consulta = consultar($filtro);
        $productos = [];
        //Se transforma la consulta y de paso se añade la cantidad del carrito
        while ($res = mysqli_fetch_assoc($consulta)) {
            foreach ($datos as $producto) {
                if ($producto[0] == $res['id']) {
                    $res['cantidad'] = $producto[1];
                    break;
                }
            }
            $productos[] = $res;
        }
        echo json_encode(["resultado" => true, "datos" => $productos]);
    }else {
        echo json_encode(["resultado" => false ,"mensaje" => "El carrito está vacío"]);
    }
?>