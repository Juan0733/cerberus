<?php

    session_start();

    if(isset($_SESSION['datos_usuario'])){
        $tiempoLimite = 432000;
        $tiempoTranscurrido = time() -  $_SESSION['datos_usuario']['hora_sesion'];

        if($tiempoTranscurrido > $tiempoLimite){
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 3600, '/');

            if(isset($_GET['operacion']) || isset($_POST['operacion'])){
                $respuesta = [
                    'tipo' => 'ERROR',
                    'titulo' => 'Sesión Expirada',
                    'mensaje' => 'La sesión ha expirado, vuelve a ingresar al sistema.'
                ];
                echo json_encode($respuesta);
                exit();
            }

            header('Location: '.$urlBaseVariable.'sesion-expirada');
            exit();

        }elseif(isset($url) && $url[0] == 'login'){
            header('Location: '.$urlBaseVariable.$_SESSION['datos_usuario']['panel_acceso']);
            exit();
        }

    }
    // elseif(isset($_GET['operacion'])){
    //     header('Location: ../../acceso-denegado');
    //     exit();

    // }elseif(isset($_POST['operacion']) && $_POST['operacion'] != 'validar_usuario' && $_POST['operacion'] != 'validar_contrasena'){
    //     header('Location: ../../acceso-denegado');
    //     exit();
    // }

    
    