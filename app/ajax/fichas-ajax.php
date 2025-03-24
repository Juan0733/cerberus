<?php
	namespace app\ajax;
	use app\controllers\FichasController as FichasController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/fichasController.php';

    	
    //importar la clase
	if(isset($_POST['modulo_ficha'])){

		$insAprendiz = new FichasController();

		if($_POST['modulo_ficha']=="Registrar"){
			echo $insAprendiz->registrarFichaControlador();
		}
    }