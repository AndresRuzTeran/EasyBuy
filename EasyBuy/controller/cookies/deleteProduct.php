<?php
    session_start();

    $nameCookie = 'cart-'.$_SESSION['id'];

    $id = $_POST['id']; // Obtener el ID del producto a eliminar

    // Verificar si la cookie 'cart' existe
    if (isset($_COOKIE[$nameCookie])) {

        $datos = json_decode($_COOKIE[$nameCookie], true); // Decodificar los datos de la cookie

        // Recorrer los productos y eliminar el que tenga el ID igual al que se pasó
        $datosActualizados = [];
        foreach ($datos as $producto) {
            if ($producto[0] !== $id) {
                $datosActualizados[] = $producto; // Añadir productos que no coinciden
            }
        }

        // Si después de eliminar el producto la lista no está vacía, actualizar la cookie
        if (!empty($datosActualizados)) {
            setcookie($nameCookie, json_encode($datosActualizados), time() + (86400 * 1));
            echo json_encode(["resultado" => true, "mensaje" => "Producto eliminado","Array: " => $datosActualizados]);
        } else {
            // Si no hay productos en la cookie después de la eliminación, eliminar la cookie
            setcookie($nameCookie, '', time() - 3600);
            echo json_encode(["resultado" => true, "mensaje" => "Carrito vacío, cookie eliminada"]);
        }
    } else {
        echo json_encode(["resultado" => false, "mensaje" => "No existe el carrito para este usuario"]);
    }
?>