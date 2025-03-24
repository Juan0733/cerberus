<?php
	namespace app\ajax;
	use app\controllers\VehiculoController as VehiculoController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/vehiculoController.php';

	if(isset($_POST['modulo_vehiculo'])){

		$insVehiculo = new VehiculoController();

		if($_POST['modulo_vehiculo']=="registrar"){
			echo $insVehiculo->registrarVehiculoControler();	
		}elseif ($_POST['modulo_vehiculo']=="lista_propietario") {
			echo $insVehiculo->listarPropietariosVehiculosControler();
		}elseif ($_POST['modulo_vehiculo']=="eliminar") {
			echo $insVehiculo->eliminarVehiculoControler();
		}elseif ($_POST['modulo_vehiculo']=="editar") {
			echo $insVehiculo->editarVehiculoControler();

		}
	}
	if (isset($_POST['filtro'])){
		$insAprendiz = new VehiculoController();
        echo $insAprendiz->listarVehiculosControler();
	}
	if (!isset($_POST['modulo_vehiculo']) && !isset($_POST['filtro'])) {
		session_destroy();
		header("Location: " . APP_URL_BASE . "login/");
	}