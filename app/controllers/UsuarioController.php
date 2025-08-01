<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\UsuarioModel;
use App\Services\UsuarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoUsuario = new UsuarioModel();
	$objetoServicio = new UsuarioService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
       if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../sesion-expirada');
            exit();
        }
    }

    $respuesta = $objetoUsuario->validarAccesoUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
        echo json_encode($respuesta);
        exit();
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Operación No Encontrada'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../404');
            exit();
        }

    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../acceso-denegado');
            exit();
        }
    }

	if($operacion == 'validar_usuario'){
		$respuesta = $objetoServicio->sanitizarUsuarioLogin();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoUsuario->validarUsuarioLogin($respuesta['usuario']));

	}else if($operacion == 'validar_contrasena'){
		$respuesta = $objetoServicio->sanitizarDatosLogin();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoUsuario->validarContrasenaLogin($respuesta['datos_login']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	$objetoUsuario = new UsuarioModel();
	$objetoServicio = new UsuarioService();

	$operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
	unset($_GET['operacion']);

	$respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
       if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../sesion-expirada');
            exit();
        }
    }

    $respuesta = $objetoUsuario->validarAccesoUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Error de Conexión'){
        echo json_encode($respuesta);
        exit();
        
    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Operación No Encontrada'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../404');
            exit();
        }

    }elseif($respuesta['tipo'] == 'ERROR' && $respuesta['titulo'] == 'Acceso Denegado'){
        if(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false){
            echo json_encode($respuesta);
            exit();

        }else{
            header('Location: ../../acceso-denegado');
            exit();
        }
    }
	
	if($operacion == 'conteo_total_usuarios'){
		echo json_encode($objetoUsuario->conteoTotalUsuarios());
	}elseif ($operacion == 'conteo_tipo_usuario') {
		echo  json_encode($objetoUsuario->conteoTipoUsuario());
	}elseif ($operacion == 'consultar_notificaciones_usuario') {
		echo  json_encode($objetoUsuario->consultarNotificacionesUsuario());
	}elseif ($operacion == 'cerrar_sesion') {
		echo  json_encode($objetoUsuario->cerrarSesion());
	}
}