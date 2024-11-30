<?php
    session_start();

    include('../../Model/pqrs/newPqrs.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $_SESSION['id'];
    $tipo = $data[0];
    $asunto = $data[1];
    $desc = $data[2];

    $res = insertar($id,$tipo,$asunto,$desc);

    if($res){
        echo json_encode(["resultado" => true, "mensaje" => "Se ha enviado la solicitud y se ha registrado con el id $res"]);
    }else{
        echo json_encode(["resultado" => false, "mensaje" => "Error al enviar la PQRS"]);
    }
    

?>