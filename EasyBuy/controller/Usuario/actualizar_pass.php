<?php

    session_start();

    include('../../Model/Usuarios/Consultar_id.php');
    include('../../Model/Usuarios/update_pass.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $pass = $data[0];
    $new1 = $data[1];
    $new2 = $data[2];

    if($new1 == $new2){
        $verificar = consultar($id);
        if(mysqli_fetch_assoc($verificar)['pass'] == $pass){
            actualizar($id,$new1);
            echo json_encode(["resultado" => true ,"mensaje" => "Se ha actualizado la contraseña exitosamente"]);
        }else{
            echo json_encode(["resultado" => false ,"mensaje" => "La contraseña actual no es correcta"]);
        }
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Las contraseñas no coinciden"]);
    }

?>