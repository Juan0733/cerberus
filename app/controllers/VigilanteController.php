<?php
require_once "../../config/app.php";
require_once "../../vendor/autoload.php";

use App\Models\RolOperacionModel;
use App\Models\VigilanteModel;
use App\Models\UsuarioModel;
use App\Services\VigilanteService;


header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoVigilante = new VigilanteModel();
    $objetoServicio = new VigilanteService();
    $objetoUsuario = new UsuarioModel();
    $objetoRolOperacion = new RolOperacionModel();

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

   $respuesta = $objetoRolOperacion->validarAccesoOperacion($operacion);
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

	if($operacion == 'registrar_vigilante_individual'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroVigilanteIndividual();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->registrarVigilanteIndividual($respuesta['datos_vigilante']));

	}elseif($operacion == 'registrar_vigilante_carga_masiva'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroVigilanteCargaMasiva();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->registrarVigilanteCargaMasiva($respuesta['datos_vigilantes']));

	}elseif($operacion == 'actualizar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionVigilante();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->actualizarVigilante($respuesta['datos_vigilante']));

	}elseif($operacion == 'habilitar_vigilante'){
        $respuesta = $objetoServicio->sanitizarDatosHabilitacionUsuario();
        if ($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVigilante->habilitarVigilante($respuesta['datos_usuario']));

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
    $objetoRolOperacion = new RolOperacionModel();

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

    $respuesta = $objetoRolOperacion->validarAccesoOperacion($operacion);
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
	
}