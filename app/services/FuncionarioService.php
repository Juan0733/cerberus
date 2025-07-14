<?php
namespace app\services;

class FuncionarioService{

    public function sanitizarDatosRegistroFuncionario(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['tipo_contrato'] == '' || $_POST['brigadista'] == '' || $_POST['rol'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $tipoContrato = $this->limpiarDatos($_POST['tipo_contrato']);
        $brigadista = $this->limpiarDatos($_POST['brigadista']);
        $rol = $this->limpiarDatos($_POST['rol']);
        $fechaFinContrato = 'NULL';
        $contrasena = 'NULL';
        $estadoUsuario = 'NULL';
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']); 

        $datos = [
			[
				'filtro' => "(CC|CE|TI|PP|PEP)",
				'cadena' => $tipoDocumento
            ],
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $nombres
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $apellidos
            ],
            [
                'filtro' => "[0-9]{10}",
                'cadena' => $telefono
            ],
            [
                'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                'cadena' => $correoElectronico
            ],
            [
                'filtro' => "(PLANTA|CONTRATISTA)",
                'cadena' => $tipoContrato
            ],
            [
                'filtro' => "(SI|NO)",
                'cadena' => $brigadista
            ],
            [
                'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TECNICO|PERSONAL ASEO)',
                'cadena' => $rol
            ]
		];

        if($tipoContrato == 'CONTRATISTA'){
            if(!isset($_POST['fecha_fin_contrato']) || $_POST['fecha_fin_contrato'] == ''){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }

            $fechaFinContrato = $this->limpiarDatos($_POST['fecha_fin_contrato']);
            unset($_POST['fecha_fin_contrato']);

            $datos[] = [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinContrato
            ];
        }

        if($rol == 'COORDINADOR'){
            if(!isset($_POST['contrasena']) || $_POST['contrasena'] == ''){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }

            $contrasena = $this->limpiarDatos($_POST['contrasena']);
            $estadoUsuario = "'ACTIVO'";
            unset($_POST['contrasena']);

            $datos[] = [
                'filtro' => '[a-zA-Z0-9]{8,}',
                'cadena' => $contrasena
            ];
        }
		
        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $fechaFinContrato = $fechaFinContrato != 'NULL' ? "'$fechaFinContrato'" : $fechaFinContrato;
        if($contrasena != 'NULL'){
            $contrasena = md5($contrasena);
            $contrasena = "'$contrasena'";
        }

        $datosFuncionario = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'tipo_contrato' => $tipoContrato,
            'brigadista' => $brigadista,
            'rol' => $rol,
            'fecha_fin_contrato' => $fechaFinContrato,
            'contrasena' => $contrasena,
            'estado_usuario' => $estadoUsuario
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_funcionario" => $datosFuncionario
        ];
        return $respuesta;
    }

    public function sanitizarDatosAutoRegistroFuncionario(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['tipo_contrato'] == '' || $_POST['brigadista'] == '' || $_POST['rol'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $tipoContrato = $this->limpiarDatos($_POST['tipo_contrato']);
        $brigadista = $this->limpiarDatos($_POST['brigadista']);
        $rol = $this->limpiarDatos($_POST['rol']);
        $fechaFinContrato = 'NULL';
        $contrasena = 'NULL';
        $estadoUsuario = 'NULL';
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']); 

        $datos = [
			[
				'filtro' => "(CC|CE|TI|PP|PEP)",
				'cadena' => $tipoDocumento
            ],
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $nombres
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $apellidos
            ],
            [
                'filtro' => "[0-9]{10}",
                'cadena' => $telefono
            ],
            [
                'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                'cadena' => $correoElectronico
            ],
            [
                'filtro' => "(PLANTA|CONTRATISTA)",
                'cadena' => $tipoContrato
            ],
            [
                'filtro' => "(SI|NO)",
                'cadena' => $brigadista
            ],
            [
                'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TECNICO|PERSONAL ASEO)',
                'cadena' => $rol
            ]
		];

        if($tipoContrato == 'CONTRATISTA'){
            if(!isset($_POST['fecha_fin_contrato']) || $_POST['fecha_fin_contrato'] == ''){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }

            $fechaFinContrato = $this->limpiarDatos($_POST['fecha_fin_contrato']);
            unset($_POST['fecha_fin_contrato']);

            $datos[] = [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinContrato
            ];
        }

        if($rol == 'COORDINADOR'){
           $estadoUsuario = "'INACTIVO'";
        }
		
        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $fechaFinContrato = $fechaFinContrato != 'NULL' ? "'$fechaFinContrato'" : $fechaFinContrato;
        
        $datosFuncionario = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'tipo_contrato' => $tipoContrato,
            'brigadista' => $brigadista,
            'rol' => $rol,
            'fecha_fin_contrato' => $fechaFinContrato,
            'contrasena' => $contrasena,
            'estado_usuario' => $estadoUsuario
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_funcionario" => $datosFuncionario
        ];
        return $respuesta;
    }

    public function sanitizarDatosActualizacionFuncionario(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['tipo_contrato'] == '' || $_POST['brigadista'] == '' || $_POST['rol'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $tipoContrato = $this->limpiarDatos($_POST['tipo_contrato']);
        $brigadista = $this->limpiarDatos($_POST['brigadista']);
        $rol = $this->limpiarDatos($_POST['rol']);
        $fechaFinContrato = 'NULL';
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['tipo_contrato'], $_POST['brigadista'], $_POST['rol']); 

        $datos = [
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $nombres
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,50}",
                'cadena' => $apellidos
            ],
            [
                'filtro' => "[0-9]{10}",
                'cadena' => $telefono
            ],
            [
                'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                'cadena' => $correoElectronico
            ],
            [
                'filtro' => "(PLANTA|CONTRATISTA)",
                'cadena' => $tipoContrato
            ],
            [
                'filtro' => "(SI|NO)",
                'cadena' => $brigadista
            ],
            [
                'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TECNICO|PERSONAL ASEO)',
                'cadena' => $rol
            ]
		];

        if($tipoContrato == 'CONTRATISTA'){
            if(!isset($_POST['fecha_fin_contrato']) || $_POST['fecha_fin_contrato'] == ''){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }

            $fechaFinContrato = $this->limpiarDatos($_POST['fecha_fin_contrato']);
            unset($_POST['fecha_fin_contrato']);

            $datos[] = [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinContrato
            ];
        }

        if($rol == 'COORDINADOR'){
            if(!isset($_POST['contrasena'])){
                $respuesta = [
                    "tipo" => "ERROR",
                    "titulo" => 'Campos Obligatorios',
                    "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                ];
                return $respuesta;
            }

            $contrasena = $this->limpiarDatos($_POST['contrasena']);
            unset($_POST['contrasena']);

            $datos[] = [
                'filtro' => '|[a-zA-Z0-9]{8,}',
                'cadena' => $contrasena
            ];
        }
		
        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $fechaFinContrato = $fechaFinContrato != 'NULL' ? "'$fechaFinContrato'" : $fechaFinContrato;

        $datosFuncionario = [
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'tipo_contrato' => $tipoContrato,
            'brigadista' => $brigadista,
            'rol' => $rol,
            'fecha_fin_contrato' => $fechaFinContrato
        ];

        if(isset($contrasena) && !empty($contrasena)){
            $contrasena = md5($contrasena);
            $contrasena = "'$contrasena'";
            $datosFuncionario['contrasena'] = $contrasena;
        }

        $respuesta = [
            "tipo" => "OK",
            "datos_funcionario" => $datosFuncionario
        ];
        return $respuesta;
    }

    public function sanitizarDatosHabilitacionFuncionario(){
        if(!isset($_POST['numero_documento'], $_POST['contrasena']) || $_POST['numero_documento'] == '' || $_POST['contrasena'] == ''){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $contrasena = $this->limpiarDatos($_POST['contrasena']);
        unset($_POST['documento_visitante'], $_POST['contrasena']); 
		
		$datos = [
            [
				'filtro' => "[A-Za-z0-9]{6,15}",
				'cadena' => $numeroDocumento
            ],
            [
                'filtro' => "[a-zA-Z0-9]{8,}",
                'cadena' => $contrasena
            ]
		];

        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.".$dato['cadena'],
                ];
                return $respuesta;
			}
        }

        $contrasena = md5($contrasena);

        $datosFuncionario = [
            'numero_documento' => $numeroDocumento,
            'contrasena' => $contrasena
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_funcionario" => $datosFuncionario
        ];
        return $respuesta;
    }

    public function sanitizarParametros()
    {
        $parametros = [];

        if(isset($_GET['brigadista'])){
            $brigadista = $this->limpiarDatos($_GET['brigadista']);
            unset($_GET['brigadista']);

            if(preg_match('/^(SI|NO)$/', $brigadista)){
                 $parametros['brigadista'] = $brigadista;
            }
        }

        if(isset($_GET['ubicacion'])){
            $ubicacion = $this->limpiarDatos($_GET['ubicacion']);
            unset($_GET['ubicacion']);

            if(preg_match('/^(DENTRO|FUERA)$/', $ubicacion)){
                 $parametros['ubicacion'] = $ubicacion;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento= $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['rol'])){
            $rol = $this->limpiarDatos($_GET['rol']);
            unset($_GET['rol']);

            if(preg_match('/^(COORDINADOR|INSTRUCTOR|PERSONAL ADMINISTRATIVO|PERSONAL ASEO|SOPORTE TECNICO|SUBDIRECTOR)$/', $rol)){
                $parametros['rol'] = $rol;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }

    public function limpiarDatos($dato){
		$palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==",";","::"];


		$dato=trim($dato);
		$dato=stripslashes($dato);

		foreach($palabras as $palabra){
			$dato=str_ireplace($palabra, "", $dato);
		}

		$dato=trim($dato);
		$dato=stripslashes($dato);

		return $dato;
	}
}
    

