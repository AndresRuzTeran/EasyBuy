<?php
    session_start();

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data[0];
    $tipo = $data[1];

    $_SESSION['id'] = $id;
    $_SESSION['tipo'] = $tipo;
?>