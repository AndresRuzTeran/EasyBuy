<?php

    session_start();

    include('../../Model/Usuarios/Consultar_usuario.php');
    include('../../Model/Usuarios/update_usuario.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $name = $data[0];
    $lastname = $data[1];
    $correo = $data[2];
    $cell = $data[3];
    $ciudad = $data[4];
    $dir = $data[5];


    $verificar = consultar($correo);

    if(mysqli_num_rows($verificar)>0 && mysqli_fetch_assoc($verificar)['id'] != $id){
        echo json_encode(["resultado" => false ,"mensaje" => "El correo ya está en uso"]);
    }else{
        $query = actualizar($id,$name,$lastname,$correo,$cell,$ciudad,$dir);
        if($query){
            echo json_encode(["resultado" => true ,"mensaje" => "Actualización exitosa"]);
        }else{
            echo json_encode(["resultado" => false ,"mensaje" => "Error al actualizar"]);
        }
    }


?>