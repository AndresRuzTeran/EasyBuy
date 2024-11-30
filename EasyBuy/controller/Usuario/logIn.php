<?php
    include('../../Model/Usuarios/Consultar_usuario.php');
    include('../../Model/store/Consultar_store.php');

    $data = json_decode(file_get_contents("php://input"), true);

    $correo = $data[0];
    $pass = $data[1];

    $verificar_usuario = consultar($correo);
    $verificar_store = consultar_store($correo);

    if(mysqli_num_rows($verificar_usuario)>0 or mysqli_num_rows($verificar_store)>0){
        //Si el correo es de un cliente
        if(mysqli_num_rows($verificar_usuario)>0){
            $res = mysqli_fetch_assoc($verificar_usuario);
            if($res['pass'] == $pass){
                if($res['estado'] == 1){
                    echo json_encode(["resultado" => true ,"mensaje" => "Inicio válido", "id" => $res['id'],"tipo" => 1]);
                }else{
                    echo json_encode(["resultado" => false ,"mensaje" => "Usuario inactivo, contacte con soporte"]);
                }            
            }else{
                echo json_encode(["resultado" => false ,"mensaje" => "Contraseña incorrecta"]);
            }
        }else{//Si el correo es de una tienda
            $res = mysqli_fetch_assoc($verificar_store);
            if($res['pass'] == $pass){
                if($res['estado'] == 1){
                    echo json_encode(["resultado" => true ,"mensaje" => "Inicio válido", "id" => $res['id'], "tipo" => 2]);
                }else{
                    echo json_encode(["resultado" => false ,"mensaje" => "Usuario inactivo, contacte con soporte"]);
                }            
            }else{
                echo json_encode(["resultado" => false ,"mensaje" => "Contraseña incorrecta"]);
            }
        }
        
    }else{
        echo json_encode(["resultado" => false ,"mensaje" => "Usuario no se encuentra registrado"]);
    }

?>