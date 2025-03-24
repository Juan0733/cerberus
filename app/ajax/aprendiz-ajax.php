<?php
	namespace app\ajax;
	use app\controllers\AprendizController as AprendizController;
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";
	require '../controllers/aprendizController.php';

	
    //importar la clase
	if(isset($_POST['modulo_aprendiz'])){

		$insAprendiz = new AprendizController();

		if($_POST['modulo_aprendiz']=="Registrar"){
			echo $insAprendiz->registrarAprendizControlador();
		}elseif ($_POST['modulo_aprendiz'] == "inhabilitar") {
            $id_aprendiz = $_POST['id_aprendiz'];
            echo $insAprendiz->inhabilitarAprendizController($id_aprendiz);
        } elseif ($_POST['modulo_aprendiz'] == "habilitar") {
            $id_aprendiz = $_POST['id_aprendiz'];
            echo $insAprendiz->habilitarAprendizController($id_aprendiz);
        } elseif ($_POST['modulo_aprendiz'] == "editar") {
			$id_aprendiz = $_POST['id_aprendiz'];
			if (empty($id_aprendiz)) {
                echo "Error al obtener los datos del aprendiz";
            } else {
                header("Location: ".APP_URL_BASE."editar-aprendiz/".$id_aprendiz."/");
            }
		} elseif ($_POST['modulo_aprendiz'] == "editar_f") {
			$id_aprendiz = $_POST['numero_documento_a'];
			echo $insAprendiz->editarAprendizController($id_aprendiz);
		}
	}
	if (isset($_POST['filtro'])){
		$insAprendiz = new AprendizController();
        echo $insAprendiz->listarAprendicesControler();
	}
	if (isset($_POST['nombre_programa'])) {
		$insAprendiz = new AprendizController();
		echo $insAprendiz->obtenerFichasController($_POST['nombre_programa']);
	}
	if (!isset($_POST['modulo_aprendiz']) && !isset($_POST['filtro']) && !isset($_POST['nombre_programa'])) {
		session_destroy();
		header("Location: " . APP_URL_BASE . "login/");
	}