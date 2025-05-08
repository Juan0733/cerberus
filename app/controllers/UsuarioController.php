<?php
require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\models\UsuarioModel;
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operacion']) && $_POST['operacion'] != "") {
	
	$insUsuario = new UsuarioModel();
	$operacion = $insUsuario->limpiarDatos($_POST['operacion']);

	if($operacion == 'validar_usuario'){
		if(!isset($_POST['usuario']) || $_POST['usuario'] == ''){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Campos Obligatorios',
				"mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.',
				"icono" => "warning",
				"cod_error"=> "350"
			];

			echo json_encode($respuesta);
			exit();
		}

		$usuario = $insUsuario->limpiarDatos($_POST['usuario']);

		$datos = [
			[
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $usuario
			]
		];

		if(!$insUsuario->verificarDatos($datos)){
			$respuesta = [
				"tipo" => "ERROR",
				'titulo' => "Formato Inválido",
				'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
				"icono" => "warning",
				"cod_error"=> "350"
			];

			echo json_encode($respuesta);
			exit();
		}

		echo json_encode($insUsuario->validarUsuarioLogin($usuario));

	}else if($operacion == 'validar_contrasena'){

		if(!isset($_POST['usuario'], $_POST['contrasena'], $_POST['tabla']) || $_POST['usuario'] == '' || $_POST['contrasena'] == '' || $_POST['tabla'] == ''){
			$respuesta = [
				"tipo" => "ERROR",
				"titulo" => 'Campos Obligatorios',
				"mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.',
				"icono" => "warning",
				"cod_error"=> "350"
			];

			echo json_encode($respuesta);
			exit();
		}

		$usuario = $insUsuario->limpiarDatos($_POST['usuario']);
		$contrasena = $insUsuario->limpiarDatos($_POST['contrasena']);
		$tabla = $insUsuario->limpiarDatos($_POST['tabla']);

		$datos = [
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $usuario
			],
			[
				'filtro' => "[a-zA-Z0-9]{6,15}",
				'cadena' => $contrasena
			],
			[
				'filtro' => "(vigilantes|funcionarios)",
				'cadena' => $tabla
			]
		];

		if(!$insUsuario->verificarDatos($datos)){
			$respuesta = [
				"tipo" => "ERROR",
				'titulo' => "Formato Inválido",
				'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
				"icono" => "warning",
				"cod_error"=> "350"
			];

			echo json_encode($respuesta);
			exit();
		}

		$datosLogin = [
			'usuario' => $usuario,
			'contrasena' => $contrasena,
			'tabla' => $tabla
		];

		echo json_encode($insUsuario->validarContrasenaLogin($datosLogin));
	}
	
}elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['operacion']) && $_GET['operacion'] != '' ){
	
	$insUsuario = new UsuarioModel();
	$operacion = $insUsuario->limpiarDatos($_GET['operacion']);

	if($operacion == 'conteo_total_usuarios'){
		echo json_encode($insUsuario->conteoTotalUsuarios());
	}elseif ($operacion == 'conteo_tipo_usuario') {
		echo  json_encode($insUsuario->conteoTipoUsuario());
	}
}else{
	echo "no post". $_SERVER['REQUEST_METHOD'];
}