<?php
	
	namespace app\ajax;
	use app\controllers\ContadorController as ContadorController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/contadorController.php';
	
	if (isset($_POST['modulo_conteo'])) {
		$insContador = new ContadorController();
		if ($_POST['modulo_conteo'] == 'listadoUltimosRegistros') {
			echo $insContador->listadoUltimosReportesController();
		}elseif ($_POST['modulo_conteo'] == 'conteosGrafica') {
			echo $insContador->conteosGraficaController();
		}elseif($_POST['modulo_conteo'] == 'conteosGraficaPersonas'){
			echo $insContador->conteosGraficaPersonasController();
		}
	}else {
		$insContador = new ContadorController();
		echo $insContador->contador();
	}
	