<?php
    session_start();

    unset($_SESSION['id']);
    unset($_SESSION['tipo']);

    echo json_encode(["resultado" => true ,"mensaje" => "Sesión cerrada exitosamente"]);
?>