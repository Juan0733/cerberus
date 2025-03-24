<?php
	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	
	use app\controllers\loginController;
	
	/* $datos_user = file_get_contents("php://input");
	$datos_user = json_decode($datos_user);
	$datos_usuario_id = $datos_user->num_identificacion;
	 */
	   
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$insIniciar = new loginController();
		if ($_POST['num_id_usuario'] != "" && $_POST['psw_usuario'] == "") {
			echo $insIniciar->iniciarSesionControlador();
		}elseif ($_POST['num_id_usuario'] != "" && $_POST['psw_usuario'] != "") {
			echo $insIniciar->validarContrasena();
		}
	}else{
		echo "no post". $_SERVER['REQUEST_METHOD'];
	}
		

	