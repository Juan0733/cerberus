<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\UsuarioModel;
use app\services\UsuarioService;

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$objetoUsuario = new UsuarioModel();
	$objetoServicio = new UsuarioService();

	$operacion = $objetoServicio->limpiarDatos($_POST['operacion']);
	unset($_POST['operacion']);

	if($operacion == 'validar_usuario'){
		$respuesta = $objetoServicio->sanitizarUsuarioLogin();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoUsuario->validarUsuarioLogin($respuesta['usuario']));

	}else if($operacion == 'validar_contrasena'){

		$respuesta = $objetoServicio->sanitizarDatosLogin();
		if ($respuesta['tipo'] == 'ERROR') {
			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($objetoUsuario->validarContrasenaLogin($respuesta['datos_login']));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	$objetoUsuario = new UsuarioModel();
	$objetoServicio = new UsuarioService();

	$operacion = $objetoServicio->limpiarDatos($_GET['operacion']);
	unset($_GET['operacion']);
	
	if($operacion == 'conteo_total_usuarios'){
		echo json_encode($objetoUsuario->conteoTotalUsuarios());
	}elseif ($operacion == 'conteo_tipo_usuario') {
		echo  json_encode($objetoUsuario->conteoTipoUsuario());
	}elseif ($operacion == 'cerrar_sesion') {
		echo  json_encode($objetoUsuario->cerrarSesion());
	}
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}