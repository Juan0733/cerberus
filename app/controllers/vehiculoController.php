<?php
require_once "../../config/app.php";
require_once "../../autoload.php";

use app\models\VehiculoModel;
use app\models\UsuarioModel;
use app\services\VehiculoService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion'])) {
	$objetoVehiculo= new VehiculoModel();
	$objetoServicio = new VehiculoService();
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

	if($operacion == 'registrar_vehiculo'){
		$respuesta = $objetoServicio->sanitizarDatosRegistroVehiculo();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoVehiculo->registrarVehiculo($respuesta['datos_vehiculo']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion'])){
	$objetoVehiculo= new VehiculoModel();
	$objetoServicio = new VehiculoService();
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

		echo json_encode($objetoVehiculo->consultarPropietarios($respuesta['parametros']['numero_placa']));

	}elseif($operacion == 'consultar_vehiculos'){
		$respuesta = $objetoServicio->sanitizarParametros();
		echo json_encode($objetoVehiculo->consultarVehiculos($respuesta['parametros']));

	}elseif($operacion == 'eliminar_propietario_vehiculo'){
		$respuesta = $objetoServicio->sanitizarParametros();
		if(!isset($respuesta['parametros']['numero_placa']) || !isset($respuesta['parametros']['numero_documento'])){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Error De Parámetros',
				"mensaje" => 'No se han enviado parámetros o son incorrectos.'
			];

			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoVehiculo->eliminarPropiedadVehiculo($respuesta['parametros']['numero_documento'], $respuesta['parametros']['numero_placa']));
	}
	
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}