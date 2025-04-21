<?php
    namespace app\models;
	use app\models\MainModel;

	class UsuarioModel extends MainModel{
		
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
                $panelAcceso = 'panel-principal';
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

        public function conteoTotalUsuarios(){
            $tablas = ['vigilantes', 'visitantes', 'funcionarios', 'aprendices'];
            $totalUsuarios = 0;
    
            foreach($tablas as $tabla){
                $sentenciaBuscar = "SELECT num_identificacion FROM ".$tabla." WHERE permanencia = 'DENTRO';";
    
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

                $totalUsuarios += $respuestaSentencia->num_rows;
            }

            $respuesta = [
                'tipo' => "OK",
                'titulo'=> "Conteo Éxitoso",
                'mensaje' => "El conteo de usuarios fue realizado con éxito.",
                'total_usuarios' => $totalUsuarios
            ];
            return $respuesta;
        }

        public function conteoTipoUsuario(){
            $tablas = ['aprendices', 'funcionarios', 'visitantes', 'vigilantes'];
            $usuarios = [];
            $totalUsuarios = 0;

            foreach($tablas as $tabla){
                if($tabla == 'funcionarios'){
                    // Cuando se realiza el conteo en la tabla de funcionarios, se cuentan en grupos separados los funcionarios brigadistas y los funcionarios comunes
                    $sentenciaBuscar = "SELECT num_identificacion FROM ".$tabla." WHERE permanencia = 'DENTRO' AND brigadista = 'NO';";

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

                    $cantidad = $respuestaSentencia->num_rows;
                    $usuarios[] = [
                        'tipo_usuario' => "funcionarios_comunes",
                        'cantidad' => $cantidad
                    ];

                    $totalUsuarios += $cantidad;

                    $sentenciaBuscar = "SELECT num_identificacion FROM ".$tabla." WHERE permanencia = 'DENTRO' AND brigadista = 'SI';";

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

                    $cantidad = $respuestaSentencia->num_rows;
                    $usuarios[] = [
                        'tipo_usuario' => "funcionarios_brigadistas",
                        'cantidad' => $cantidad
                    ];

                    $totalUsuarios += $cantidad;
                }else{
                    $sentenciaBuscar = "SELECT num_identificacion FROM ".$tabla." WHERE permanencia = 'DENTRO';";

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

                    $cantidad = $respuestaSentencia->num_rows;
                    $usuarios[] = [
                        'tipo_usuario' => $tabla,
                        'cantidad' => $cantidad
                    ];

                    $totalUsuarios += $cantidad;
                }
            }

            foreach ($usuarios as &$usuario) {
                // Se calcula el porcentaje de cada tipo de usuario que se encuentran dentro del sena sobre el total general de usuarios.
                if($usuario['cantidad'] < 1){
                    $porcentaje = 0;
                }else{
                    $porcentaje = $usuario['cantidad']*100/$totalUsuarios;
                }

                $usuario['porcentaje'] = $porcentaje;
            }

            $respuesta = [
                'tipo' => "OK",
                'titulo'=> "Conteo Éxitoso",
                'mensaje' => "El conteo de usuarios fue realizado con éxito.",
                'usuarios' => $usuarios
            ];

            return $respuesta;
        }
	}

    
