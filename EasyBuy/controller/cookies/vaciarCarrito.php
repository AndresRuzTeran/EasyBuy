<?php
    session_start();

    $nameCookie = 'cart-'.$_SESSION['id'];
    
    // Verificar si la cookie 'cart' existe
    if (isset($_COOKIE[$nameCookie])) {
        //eliminar la cookie
        setcookie($nameCookie, '', time() - 3600);
        echo json_encode(["resultado" => true, "mensaje" => "Carrito vacío, cookie eliminada"]);
    } else {
        echo json_encode(["resultado" => false, "mensaje" => "No existe el carrito para este usuario"]);
    }
?>