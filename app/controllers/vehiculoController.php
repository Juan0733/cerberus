<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\VehiculoModel;
use app\services\VehiculoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	$objetoVehiculo= new VehiculoModel();
	$objetoServicio = new VehiculoService();

	$operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
	if($operacion == 'registrar_vehiculo'){
		$respuesta = $objetoServicio->sanitizarDatosVehiculo();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoVehiculo->registrarVehiculo($respuesta['datos_vehiculo']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
	
	$objetoVehiculo= new VehiculoModel();
	$objetoServicio = new VehiculoService();

	$operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
	if($operacion == 'conteo_tipo_vehiculo'){
		echo json_encode($objetoVehiculo->conteoTipoVehiculo());
	}elseif($operacion == 'consultar_vehiculo'){
		$respuesta = $objetoServicio->sanitizarParametros();
		if(empty($respuesta['parametros'])){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Error De Parámetros',
				"mensaje" => 'No se han enviado parámetros o son incorrectos.'
			];

			echo json_encode($respuesta);
			exit();
		}
		
		echo json_encode($objetoVehiculo->consultarVehiculo($respuesta['parametros']['numero_placa']));
	}elseif($operacion == 'consultar_propietarios'){
		$respuesta = $objetoServicio->sanitizarParametros();
		if(empty($respuesta['parametros'])){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Error De Parámetros',
				"mensaje" => 'No se han enviado parámetros o son incorrectos.'
			];

			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoVehiculo->consultarPropietariosVehiculo($respuesta['parametros']['numero_placa']));

	}
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}