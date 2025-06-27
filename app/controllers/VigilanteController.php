<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\VigilanteModel;
use app\models\UsuarioModel;
use app\services\VigilanteService;


header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoVigilante = new VigilanteModel();
    $objetoServicio = new VigilanteService();
    $objetoUsuario = new UsuarioModel();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $objetoUsuario->validarPermisosUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR'){
        header('Location: ../../acceso-denegado');
        exit();
    }

	if($operacion == 'registrar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroVigilante();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->registrarVigilante($respuesta['datos_vigilante']));

	}elseif($operacion == 'auto_registrar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosAutoRegistroVigilante();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->registrarVigilante($respuesta['datos_vigilante']));

	}elseif($operacion == 'actualizar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionVigilante();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->actualizarVigilante($respuesta['datos_vigilante']));

	}elseif($operacion == 'habilitar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosHabilitacionVigilante();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->habilitarVigilante($respuesta['datos_vigilante']));

	}elseif($operacion == 'guardar_puerta'){
        $respuesta = $objetoServicio->sanitizarDatosPuerta();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->guardarPuerta($respuesta['puerta']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	$objetoVigilante = new VigilanteModel();
    $objetoServicio = new VigilanteService();
    $objetoUsuario = new UsuarioModel();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    $respuesta = $objetoUsuario->validarTiempoSesion();
    if($respuesta['tipo'] == 'ERROR'){
        echo json_encode($respuesta);
        exit();
    }

    $respuesta = $objetoUsuario->validarPermisosUsuario($operacion);
    if($respuesta['tipo'] == 'ERROR'){
        header('Location: ../../acceso-denegado');
        exit();
    }
    if($operacion == 'consultar_vigilantes'){
        $respuesta = $objetoServicio->sanitizarParametros();
        echo json_encode($objetoVigilante->consultarVigilantes($respuesta['parametros']));

    }elseif($operacion == 'consultar_vigilante'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['numero_documento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoVigilante->consultarVigilante($respuesta['parametros']['numero_documento']));

    }elseif($operacion == 'inhabilitar_vigilante'){
        $respuesta = $objetoServicio->sanitizarParametros();
        if(!isset($respuesta['parametros']['numero_documento'])){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Error De Parámetros',
                "mensaje" => 'No se han enviado parámetros o son incorrectos.',
            ];

            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoVigilante->inhabilitarVigilante($respuesta['parametros']['numero_documento']));

    }elseif($operacion == 'consultar_puerta'){
        echo json_encode($objetoVigilante->consultarPuertaActual());
    }
	
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}