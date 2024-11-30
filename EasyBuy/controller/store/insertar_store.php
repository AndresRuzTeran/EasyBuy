<?php

    include('../../Model/Usuarios/Consultar_usuario.php');
    include('../../Model/store/Consultar_store.php');
    include('../../Model/store/Insertar_store.php');

    $data = json_decode(file_get_contents("php://input"), true);

    
    $name = $data[0];
    $nit = $data[1];
    $correo = $data[2];
    $cell = $data[3];
    $pass = $data[4];
    $ciudad = $data[6];
    $dir = $data[7];
    $est = 1;


    $verificar_usuario = consultar($correo);
    $verificar_store = consultar_store($correo);

    if(mysqli_num_rows($verificar_usuario)>0 or mysqli_num_rows($verificar_store)>0){
        echo json_encode(["resultado" => false ,"mensaje" => "El correo ya está en uso"]);
    }else{

        $query = insertar($name,$nit,$correo,$cell,$pass,$ciudad,$dir,$est);
        if($query){
            echo json_encode(["resultado" => true ,"mensaje" => "Registro exitoso"]);
        }else{
            echo json_encode(["resultado" => false ,"mensaje" => "Error al registrarse"]);
        }
        
    }


?>