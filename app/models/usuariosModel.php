<?php
    namespace app\models;
	use app\models\mainModel;

	class UsuariosModel extends mainModel{
		
		public function validarUsuarioLogin($usuario){
            $tablas = ['vigilantes', 'funcionarios'];
    
            foreach ($tablas as $tabla) {
                if($tabla == 'vigilantes'){
                    $sentenciaBuscar = "SELECT `num_identificacion` FROM `$tabla` WHERE  num_identificacion = '$usuario' AND estado = 'ACTIVO';";

                }elseif($tabla == 'funcionarios'){
                    $sentenciaBuscar = "SELECT `num_identificacion` FROM `$tabla` WHERE  num_identificacion = '$usuario' AND estado = 'ACTIVO' AND (rol_usuario = 'CO' OR rol_usuario = 'SB');";
                }

                
                $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);

                if (!$respuestaSentencia) {
                    $respuesta = [
                        "tipo"=> "ERROR",
                        "titulo" => 'Error de Conexión',
                        "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                        "icono" => "warning",
                        "cod_error"=> "350"
                    ];
                    return $respuesta;
                }

                if ($respuestaSentencia->num_rows > 0) {
                    $respuesta = [
                        'tipo' => 'OK',
                        'tabla' => $tabla
                    ];
                    return $respuesta; 
                }
            }

            $respuesta = [
                "tipo"=>"ERROR",
                "titulo" =>'Acceso Denegado',
                "mensaje"=> 'Lo sentimos, parece que no tienes acceso a Cerberus o tu número de identificación es incorrecto.',
                "icono" => "warning",
                "cod_error"=> "350"
            ];
            
            return $respuesta;
        }

		public function validarContrasenaLogin($datosLogin){
			
            $sentenciaBuscar = "SELECT * FROM ".$datosLogin['tabla']." WHERE  num_identificacion = '".$datosLogin['usuario']."' AND credencial = MD5('".$datosLogin['contrasena']."');";
						
            $respuestaSentencia = $this->ejecutarConsulta($sentenciaBuscar);
            if (!$respuestaSentencia) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Error de Conexión',
                    "mensaje"=> 'Lo sentimos, parece que ocurrio un error con la base de datos, por favor intentalo mas tarde.',
                    "icono" => "warning",
                    "cod_error"=> "350"
                ];
                return $respuesta;
            }

            if ($respuestaSentencia->num_rows < 1) {
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" => 'Acceso Denegado',
                    "mensaje"=> 'Lo sentimos, parece que tu contraseña es incorrecta.',
                    "icono" => "warning",
                    "cod_error"=> "350"
                ];
                return $respuesta;
            }

            $datosUsuario = $respuestaSentencia->fetch_assoc();

            // Se valida nuevamente que el rol del usuario tenga acceso al sistema
            if($datosUsuario['rol_usuario'] != 'VI' && $datosUsuario['rol_usuario'] != 'JV' && $datosUsuario['rol_usuario'] != 'CO' && $datosUsuario['rol_usuario'] != 'SB'){
                $respuesta = [
                    "tipo"=>"ERROR",
                    "titulo" =>'Acceso Denegado',
                    "mensaje"=> 'Lo sentimos, este rol no esta autorizado parece acceder a Cerberus.',
                    "icono" => "warning",
                    "cod_error"=> "350"
                ];
                return $respuesta;

            }elseif($datosUsuario['rol_usuario'] == 'VI'){
                $panelAcceso = 'panel-entrada';
            }else{
                $panelAcceso = 'panel-principal-jv';
            }

            $_SESSION['datos_usuario'] = $datosUsuario;
            $respuesta = [
                'tipo' => 'OK',
                'titulo' => 'Login Éxitoso',
                'mensaje' => 'Usuario autorizado para acceder a cerberus',
                'ruta' => $panelAcceso
            ];
            return $respuesta;
        }

		public function cerrarSesion($vista, $urlBase){
			if ($vista == '404') {
				return false;
			}else {
				session_destroy();
	
				if(headers_sent()){
					echo "<script> window.location.href='".$urlBase."'; </script>";
				}else{
					header("Location: ".$urlBase);
				}
			}
		}

	}
