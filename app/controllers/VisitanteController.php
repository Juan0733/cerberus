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
	if($operacion == 'registrar_visitante'){
        $respuesta = $objetoServicio->sanitizarDatosVisitante();
        if ($respuesta['tipo'] == 'ERROR') {
            echo json_encode($respuesta);
            exit();
        }

		echo json_encode($objetoVisitante->registrarVisitante($respuesta['datos_visitante']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}