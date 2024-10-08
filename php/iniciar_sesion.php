<?php
	/*== Almacenando datos ==*/
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']);


    /*== Verificando campos obligatorios ==*/
    if($usuario=="" || $clave==""){
        echo '
            <div class="message_error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                <p style="color:red;">No has llenado todos los campos que son obligatorios</p>
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="message_error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
               <p style="color:red;">El USUARIO no coincide con el formato solicitado</p>
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        echo '
            <div class="message_error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                <p style="color:red;">La clave no coincide con el formato solicitado</p>
            </div>
        ';
        exit();
    }


    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");
    if($check_user->rowCount()==1){

    	$check_user=$check_user->fetch();

    	if($check_user['usuario_usuario']==$usuario && password_verify($clave, $check_user['usuario_clave'])){

    		$_SESSION['id']=$check_user['usuario_id'];
    		$_SESSION['nombre']=$check_user['usuario_nombre'];
    		$_SESSION['apellido']=$check_user['usuario_apellido'];
    		$_SESSION['usuario']=$check_user['usuario_usuario'];

    		 // Verificar si es administrador o cliente
             if ($check_user['usuario_rol'] == 1) { // Administrador
                if (headers_sent()) {
                    echo "<script> window.location.href='index.php?vista=home'; </script>";
                } else {
                    header("Location: index.php?vista=home");
                }
            } else { // Cliente
                if (headers_sent()) {
                    echo "<script> window.location.href='index.php?vista=tienda'; </script>";
                } else {
                    header("Location: index.php?vista=tienda");
                }
            }
    
        } else {
            echo '
                <div class="message_error">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    <p style="color:red;">Usuario o clave incorrectos</p>
                </div>
            ';
        }
    } else {
        echo '
            <div class="message_error">
                <strong>¡Ocurrio un error inesperado!</strong><br>
               <p style="color:red;"> Usuario o clave incorrectos</p>
            </div>
        ';
    }
    $check_user = null;
    ?>