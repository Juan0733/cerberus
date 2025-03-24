<?php
	namespace app\ajax;
	use app\controllers\VisitanteController as VisitanteController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/visitanteController.php';


	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$insVis = new VisitanteController();
		if ($_POST['nombres_visitante'] != "" && $_POST['telefono_visitante'] != "") {
			echo $insVis->registrarVisitanteControler();
		}elseif ($_POST['nombres_visitante'] == "" && $_POST['telefono_visitante'] == "") {
			echo 'hola';
		}

	}
		
