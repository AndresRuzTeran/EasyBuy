<?php

    session_start();

    $nameCookie = 'cart-'.$_SESSION['id'];

    $data = json_decode(file_get_contents("php://input"), true);

    if(isset($_COOKIE[$nameCookie])) {
        $datos = json_decode($_COOKIE[$nameCookie], true);
        foreach ($datos as &$producto) {
            if ($producto[0] == $data[0]) {
                $producto[1] = $data[1];
                break;
            }
        }

        // Guardar el array actualizado en la cookie
        setcookie($nameCookie, json_encode($datos), time() + (86400 * 1));

        echo json_encode(["resultado" => true, "mensaje" => "Producto actualizado"]);
    }else {
        echo json_encode(["resultado" => false ,"mensaje" => "Carrito vacío"]);
    }
?>