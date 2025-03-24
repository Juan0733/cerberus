<?php

	namespace app\ajax;
	use app\controllers\vigilanteController as vigilanteController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/vigilanteController.php';


	// Verifica si se envió la variable POST 'modulo_vigilante'
    if(isset($_POST['modulo_vigilante'])){

		// Crea una instancia de la clase VigilanteController
		$insVigilante = new vigilanteController();

		// Verifica si la acción es para registrar un nuevo vigilante
		if($_POST['modulo_vigilante']=="registrar"){
			echo $insVigilante->registrarVigilanteControlador();
		}elseif  ($_POST['modulo_vigilante'] == "actualizar") {
            echo $insVigilante->editarVigilanteController();
        } elseif($_POST['modulo_vigilante'] == "editar") {
            $id_vigilante = $_POST['id_vigilante'];
			if (empty($id_vigilante)) {
                echo "Error al obtener los datos del vigilante";
            } else {
                header("Location: ".APP_URL_BASE."editar-vigilante/".$id_vigilante."/");
            }
        }	
	}

	// Verifica si se envió la variable POST 'filtro'
	if (isset($_POST['filtro'])) {
		$insVigilante = new VigilanteController();
			echo $insVigilante->listarVigilanteControler();
	} 

	// Si ninguna de las condiciones anteriores está presente, destruye la sesión y redirige a la página de login
	if (!isset($_POST['modulo_vigilante']) && !isset($_POST['filtro'])) {
		session_destroy();
		header("Location: " . APP_URL_BASE . "login/");
	}

	?>
