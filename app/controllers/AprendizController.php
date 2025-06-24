<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\AprendizModel;
use app\services\AprendizService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	
	$objetoAprendiz = new AprendizModel();
    $objetoServicio = new AprendizService();

    $operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

    if($operacion == 'registrar_aprendiz'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroAprendiz();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAprendiz->registrarAprendiz($respuesta['datos_aprendiz']));

    }elseif($operacion == 'actualizar_aprendiz'){
        $respuesta = $objetoServicio->sanitizarDatosActualizacionAprendiz();
        if($respuesta['tipo'] == 'ERROR'){
            echo json_encode($respuesta);
            exit();
        }

        echo json_encode($objetoAprendiz->actualizarAprendiz($respuesta['datos_aprendiz']));

    }

}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
    $objetoAprendiz = new AprendizModel();
    $objetoServicio = new AprendizService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    if($operacion == 'consultar_aprendices'){
        $respuesta = $objetoServicio->sanitizarParametros();
        echo json_encode($objetoAprendiz->consultarAprendices($respuesta['parametros']));

    }elseif($operacion == 'consultar_aprendiz'){
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

        echo json_encode($objetoAprendiz->consultarAprendiz($respuesta['parametros']['numero_documento']));

    }
}