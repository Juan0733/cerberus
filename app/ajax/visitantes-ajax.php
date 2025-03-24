<?php
	namespace app\ajax;
	use app\controllers\VisitanteController as VisitanteController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/visitanteController.php';

	if(isset($_POST['modulo_visitante'])){

		$insVisitante = new VisitanteController();

		if($_POST['modulo_visitante']=="registrar"){
			echo $insVisitante->registrarVisitanteControler();
		}elseif ($_POST['modulo_visitante']=="eliminar") {
			/* echo $insVisitante->eliminarVisitanteControlador(); */
		}elseif ($_POST['modulo_visitante']=="editar") {
			/* echo $insVisitante->eliminarVisitanteControlador(); */
		}
	}
	

	if (isset($_POST['filtro'])) {
		$insVisitante = new VisitanteController();
			echo $insVisitante->ListarVisitanteController();
	}
	if (!isset($_POST['filtro']) && !isset($_POST['modulo_visitante'])) {
		session_destroy();
		header("Location: ".APP_URL_BASE."login/");
	}