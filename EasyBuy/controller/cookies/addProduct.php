<?php

    session_start();

    $nameCookie = 'cart-'.$_SESSION['id'];

    $data = json_decode(file_get_contents("php://input"), true);

    $newProduct = [[$data[0], $data[1]]];

    $miArrayJson = json_encode($newProduct);

    if(isset($_COOKIE[$nameCookie])) {
        $datos = json_decode($_COOKIE[$nameCookie], true);
        $found = false;
        foreach ($datos as &$producto) {
            if ($producto[0] == $data[0]) {
                $producto[1] += $data[1];
                $found = true;
                break;
            }
        }

        // Si no se encontró el producto, agregar $newProduct al array $datos
        if (!$found) {
            $datos[] = $newProduct[0];
        }

        // Guardar el array actualizado en la cookie
        setcookie($nameCookie, json_encode($datos), time() + (86400 * 1));

        echo json_encode(["resultado" => true, "mensaje" => $found ? "Producto actualizado" : "Producto añadido", "datos" => $datos]);
    }else {
        setcookie($nameCookie,$miArrayJson, time() + (86400 * 1));
        echo json_encode(["resultado" => true ,"mensaje" => "Se creo la cookie", "Valor" => $newProduct]);
    }
?>