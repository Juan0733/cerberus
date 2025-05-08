<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\VehiculoModel;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	$insVehiculo= new VehiculoModel();
	$operacion = $insVehiculo->limpiarDatos($_GET['operacion']);

	if($operacion == 'conteo_tipo_vehiculo'){
		echo json_encode($insVehiculo->conteoTipoVehiculo());
	}
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}