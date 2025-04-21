<?php
    require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

    use app\models\VehiculoModel;

	header('Content-Type: application/json; charset=utf-8');

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] != "") {
		
	}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['accion']) && $_GET['accion'] != '' ){
		
		$insVehiculo= new VehiculoModel();
		$accion = $insVehiculo->limpiarDatos($_GET['accion']);

		if($accion == 'conteoTipoVehiculo'){
			echo json_encode($insVehiculo->conteoTipoVehiculo());
		}
	}else{
		echo "no post". $_SERVER['REQUEST_METHOD'];
	}