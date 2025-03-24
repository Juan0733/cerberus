<?php

	namespace app\controllers;
	use app\models\mainModel;

	class loginController extends mainModel{
		/*----------  Controlador iniciar sesion  ----------*/
		public function iniciarSesionControlador(){
			if ($_SERVER['REQUEST_METHOD'] != 'POST' ) {
				header("location:".APP_URL_BASE_LOGIN);
				exit;
			}else {
				if (!isset($_POST['num_id_usuario']) || $_POST['num_id_usuario'] == "" || strlen($_POST['num_id_usuario']) < 6 || strlen($_POST['num_id_usuario']) > 15) {
					$titulo = 'FORMATO INCOMPATIBLE';
					$descripcion = 'Recuarda que debes digitar solo numeros y minimo 6 digitos y maximo 15 digitos';
					$mensaje=[
						"tipo"=>"ERROR",
						"titulo" => $titulo,
						"mensaje"=> $descripcion,
						"icono" => "warning",
						"cod_error"=> "350"
					];
					echo json_encode($mensaje);
					exit();
				}else {
					if ($this->verificarDatos("[0-9]{6,15}", $_POST['num_id_usuario'] )) {
						$titulo = 'FORMATO INCOMPATIBLE';
						$descripcion = 'Recuarda que debes digitar solo numeros y minimo 6 digitos y maximo 15 digitos.';
						$mensaje=[
							"tipo"=>"ERROR",
							"titulo" => $titulo,
							"mensaje"=> $descripcion,
							"icono" => "warning",
							"cod_error"=> "350"
						];
						echo json_encode($mensaje);
						exit();
					}else {
						$num_id_usuario = $this->limpiarDatos($_POST['num_id_usuario']) ;
						unset($_POST['num_id_usuario']);

						$consulta = "SELECT  `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `estado`, `rol_usuario`,  `fecha_ultima_sesion`, `fecha_hora_ultimo_ingreso`, `permanencia`FROM `vigilantes` WHERE  num_identificacion = '$num_id_usuario' AND estado = 'ACTIVO';";

						$buscar_usuario_sys = $this->ejecutarConsulta($consulta);
						if (!$buscar_usuario_sys) {
							$titulo = 'ERROR DE CONEXION';
							$descripcion = 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde. e';
							$mensaje=[
								"tipo"=>"ERROR",
								"titulo" => $titulo,
								"mensaje"=> $descripcion,
								"icono" => "warning",
								"cod_error"=> "350"
							];
							echo json_encode($mensaje);
							exit();
						}else {
							if ($buscar_usuario_sys->num_rows < 1) {
								unset($buscar_usuario_sys, $consulta);

								$consulta_fn = "SELECT `tipo_documento`, `num_identificacion`, `nombres`, `apellidos`, `correo`, `telefono`, `tipo_contrato`, `rol_usuario`, `estado`, `fecha_hora_ultimo_ingreso`, `permanencia`, `fecha_hora_registro`, `num_id_usuario_que_registra`, `fecha_finalizacion_contrato` FROM `funcionarios` WHERE  num_identificacion = '$num_id_usuario' AND estado = 'ACTIVO' AND (rol_usuario = 'CO' OR rol_usuario = 'SB');";
								$buscar_usuario_sys_fn = $this->ejecutarConsulta($consulta_fn);
								if (!$buscar_usuario_sys_fn) {
									$titulo = 'ERROR DE CONEXION';
									$descripcion = 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.';
									$mensaje=[
										"tipo"=>"ERROR",
										"titulo" => $titulo,
										"mensaje"=> $descripcion,
										"icono" => "warning",
										"cod_error"=> "350"
									];
									echo json_encode($mensaje);
									exit();
								}else {
									if ($buscar_usuario_sys_fn->num_rows < 1) {
										$titulo = 'ACCESO DENEGADO';
										$descripcion = 'Lo sentimos, parece que no tienes acceso a Cerberus o tu numero de identificacion es incorrecto.';
										$mensaje=[
											"tipo"=>"ERROR",
											"titulo" => $titulo,
											"mensaje"=> $descripcion,
											"icono" => "warning",
											"cod_error"=> "350"
										];
										echo json_encode($mensaje);
										exit();
									}else {
										$datos_user_fn = $buscar_usuario_sys_fn->fetch_assoc();
										unset($buscar_usuario_sys_fn);
										if (isset($datos_user_fn['rol_usuario'],$datos_user_fn['num_identificacion'] )) {
											$datos_de_el_usuario = [
												"tipo_documento" => $datos_user_fn['tipo_documento'],
												"num_identificacion" => $datos_user_fn['num_identificacion'],
												"nombres" => $datos_user_fn['nombres'],
												"apellidos" => $datos_user_fn['apellidos'],
												"correo" => $datos_user_fn['correo'],
												"telefono" => $datos_user_fn['telefono'],
												"tipo_contrato" => $datos_user_fn['tipo_contrato'],
												"estado" => $datos_user_fn['estado'],
												"rol_usuario" => $datos_user_fn['rol_usuario'],
												"fecha_hora_ultimo_ingreso" => $datos_user_fn['fecha_hora_ultimo_ingreso'],
												"permanencia" => $datos_user_fn['permanencia'],
												"fecha_finalizacion_contrato" => $datos_user_fn['fecha_finalizacion_contrato']
											];
											$_SESSION['datos_usuario'] = $datos_de_el_usuario;
											$mensaje=[
												"titulo"=>"pw",
												"cod_error"=> "200",
											];
											echo json_encode($mensaje);
											exit();
										}
									}
								}
							}else {
								$datos_user = $buscar_usuario_sys->fetch_assoc();
								$buscar_usuario_sys->free();
								unset($buscar_usuario_sys);

								$datos_de_el_usuario = [
									"tipo_documento" => $datos_user['tipo_documento'],
									"num_identificacion" => $datos_user['num_identificacion'],
									"nombres" => $datos_user['nombres'],
									"apellidos" => $datos_user['apellidos'],
									"correo" => $datos_user['correo'],
									"telefono" => $datos_user['telefono'],
									"estado" => $datos_user['estado'],
									"rol_usuario" => $datos_user['rol_usuario'],
									"fecha_ultima_sesion" => $datos_user['fecha_ultima_sesion'],
									"fecha_hora_ultimo_ingreso" => $datos_user['fecha_hora_ultimo_ingreso'],
									"permanencia" => $datos_user['permanencia']
								];
								$_SESSION['datos_usuario'] = $datos_de_el_usuario;
								if ($_SESSION['datos_usuario']['rol_usuario'] != 'VI') {
									$mensaje=[
										"titulo"=>"pw",
										"cod_error"=> "200",
									];
									echo json_encode($mensaje);
									exit();
								}else {
									if(headers_sent()){
										$mensaje=[
											"titulo"=>"OK",
											"url"=>"".APP_URL_BASE_LOGIN."panel-principal-".strtolower($_SESSION['datos_usuario']['rol_usuario'])."/",
											"cod_error"=> "250",
										];
										echo json_encode($mensaje);
										exit();
									}else{
										$mensaje=[
											"titulo"=>"OK",
											"url"=>"".APP_URL_BASE_LOGIN."panel-principal-".strtolower($_SESSION['datos_usuario']['rol_usuario'])."/",
											"cod_error"=> "250",
										];
										echo json_encode($mensaje);
										exit();
									}
								}	
							}
						}
					}
				}
			} 
			
		}
		

		public function validarContrasena(){
			if ($_SERVER['REQUEST_METHOD'] != 'POST' ) {
				header("location:".APP_URL_BASE_LOGIN);
				exit;
			}else {
				
				if (!isset($_POST['psw_usuario']) || $_POST['psw_usuario'] == "" || strlen($_POST['psw_usuario']) < 6 || strlen($_POST['psw_usuario']) > 15) {
					$titulo = 'FORMATO INCOMPATIBLE';
					$descripcion = 'Recuerda que debes digitar como minimo 6 caracteres y maximo 15, ademas de no digitar caracteres especiales como (*-@.><) solo letrar o numeros.)';
					$mensaje=[
						"tipo"=>"ERROR",
						"titulo" => $titulo,
						"mensaje"=> $descripcion,
						"icono" => "warning",
						"cod_error"=> "350"
					];
					echo json_encode($mensaje);
					exit();
				}else {
					
					if ($this->verificarDatos("[a-zA-Z0-9]{6,15}", $_POST['psw_usuario'] )) {
						$titulo = 'FORMATO INCOMPATIBLE';
						$descripcion = 'Recuerda que debes digitar como minimo 6 caracteres y maximo 15, ademas de no digitar caracteres especiales como (*-@.><) solo letrar o numeros.).';
						$mensaje=[
							"tipo"=>"ERROR",
							"titulo" => $titulo,
							"mensaje"=> $descripcion,
							"icono" => "warning",
							"cod_error"=> "350"
						];
						echo json_encode($mensaje);
						exit();
					}else {
						$palabra_user = $this->limpiarDatos($_POST['psw_usuario']);
						if ($_SESSION['datos_usuario']['rol_usuario'] != 'JV') {
							$consulta_palabra = "SELECT `num_identificacion` FROM `funcionarios` WHERE  num_identificacion = '".$_SESSION['datos_usuario']['num_identificacion']."' AND credencial = MD5('$palabra_user');";
						}else {
							$consulta_palabra = "SELECT `num_identificacion` FROM `vigilantes` WHERE  num_identificacion = '".$_SESSION['datos_usuario']['num_identificacion']."' AND credencial = MD5('$palabra_user');";
						}
						$buscar_palabra_sys = $this->ejecutarConsulta($consulta_palabra);
						if (!$buscar_palabra_sys) {
							$titulo = 'ERROR DE CONEXION';
							$descripcion = 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.';
							$mensaje=[
								"tipo"=>"ERROR",
								"titulo" => $titulo,
								"mensaje"=> $descripcion,
								"icono" => "warning",
								"cod_error"=> "350"
							];
							echo json_encode($mensaje);
							exit();
						}else {
							if ($buscar_palabra_sys->num_rows < 1) {
								
								$titulo = 'CONTRASEÑA INVALIDA';
								$descripcion = 'Lo sentimos, parece que la contraseña que digitaste no es correcta.';
								$mensaje=[
									"tipo"=>"ERROR",
									"titulo" => $titulo,
									"mensaje"=> $descripcion,
									"icono" => "warning",
									"cod_error"=> "350"
								];
								echo json_encode($mensaje);
								exit();
							}else {
								$panel_acceso = "Login";
								if ($_SESSION['datos_usuario']['rol_usuario'] == 'CO') {
									$panel_acceso = "panel-principal-jv";
								}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'SB') {
									$panel_acceso = "panel-principal-jv";
								}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'JV') {
									$panel_acceso = "panel-principal-jv";
								}else {
									$panel_acceso = "Login";
									
									$titulo = 'ACCESO DENEGADO';
									$descripcion = 'Lo sentimos, parece que no tienes un rol asignado en Cerberus.';
									$mensaje=[
										"tipo"=>"ERROR",
										"titulo" => $titulo,
										"mensaje"=> $descripcion,
										"icono" => "warning",
										"cod_error"=> "350"
									];
									echo json_encode($mensaje);
									exit();
								}
								if(headers_sent()){
									$mensaje=[
										"titulo"=>"OK",
										"url"=>"".APP_URL_BASE_LOGIN.$panel_acceso."/",
										"cod_error"=> "250",
									];
									echo json_encode($mensaje);
									exit();
								}else{
									$mensaje=[
										"titulo"=>"OK",
										"url"=>"".APP_URL_BASE_LOGIN.$panel_acceso."/",
										"cod_error"=> "250",
									];
									echo json_encode($mensaje);
									exit();
								}

							}
						}
					}
				}
			}

		}


		/*----------  Controlador cerrar sesion  ----------*/
		public function cerrarSesionControlador($url){
			if ($url == '404') {
				return false;
			}else {
				session_destroy();
	
				if(headers_sent()){
					echo "<script> window.location.href='".APP_URL_BASE_LOGIN."'; </script>";
				}else{
					header("Location: ".APP_URL_BASE_LOGIN);
				}
			}
		}

	}