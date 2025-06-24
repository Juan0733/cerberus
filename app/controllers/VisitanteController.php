<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\VisitanteModel;
use app\services\VisitanteService;


header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoVisitante = new VisitanteModel();
    $objetoServicio = new VisitanteService();

	$operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
    unset($_POST['operacion']);

	if($operacion == 'registrar_visitante'){
        $respuesta = $objetoServicio->sanitizarDatosRegistroVisitante();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVisitante->registrarVisitante($respuesta['datos_visitante']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	$objetoVisitante = new VisitanteModel();
    $objetoServicio = new VisitanteService();

    $operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
    unset($_GET['operacion']);

    if($operacion == 'consultar_visitantes'){
        $respuesta = $objetoServicio->sanitizarParametros();
        echo json_encode($objetoVisitante->consultarVisitantes($respuesta['parametros']));

    }elseif($operacion == 'consultar_visitante'){
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

        echo json_encode($objetoVisitante->consultarVisitante($respuesta['parametros']['numero_documento']));
    }
	
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}