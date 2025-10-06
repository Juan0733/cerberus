<?php
namespace App\Services;

class FuncionarioService extends MainService{

    public function sanitizarDatosRegistroFuncionarioIndividual(){
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
                'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TÉCNICO|PERSONAL ASEO)',
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

        if($rol == 'COORDINADOR' || $rol == 'INSTRUCTOR'){
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
                'filtro' => '[A-Za-z0-9*_@\-]{8,}',
                'cadena' => $contrasena
            ];
        }
		
        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                ];
                return $respuesta;
			}
        }

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");
        $fechaFinContrato = $fechaFinContrato != 'NULL' ? "'$fechaFinContrato'" : $fechaFinContrato;
        $contrasena = $contrasena != 'NULL' ? md5($contrasena) : $contrasena;
        $contrasena = $contrasena != 'NULL' ? "'$contrasena'" : $contrasena;

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

    public function sanitizarDatosRegistroFuncionarioCargaMasiva(){
        if (!isset($_FILES['plantilla_excel']) || $_FILES['plantilla_excel'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $archivo = $_FILES['plantilla_excel'];
        unset($_FILES['plantilla_excel']); 

        $respuesta = $this->guardarArhivoExcel($archivo);
        if($respuesta == 'ERROR'){
            return $respuesta;
        }

        $rutaArchivo = $respuesta['ruta_archivo'];
        $encabezados = ['tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'telefono', 'correo_electronico', 'brigadista', 'tipo_contrato', 'fecha_fin_contrato', 'rol', 'contrasena'];
        $columnaLimite = 'K';

        $respuesta = $this->leerArchivoExcel($rutaArchivo, $encabezados, $columnaLimite);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $funcionarios = $respuesta['datos_excel'];

        if(count($funcionarios) < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Lo sentimos, pero parece que el archivo excel se encuentra vacío o no esta diligenciado correctamente.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadDatosArray($funcionarios, 'numero_documento');
        if($respuesta['tipo'] == 'ERROR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Duplicidad Datos Excel',
                'mensaje' => 'Lo sentimos, pero en el archivo excel se encontraron números de documento duplicados.'
            ];
            return $respuesta;
        }

        foreach ($funcionarios as &$funcionario) {
            $datos = [
                [
                    'filtro' => "[A-Z]{2,3}",
                    'cadena' => $funcionario['tipo_documento']
                ],
                [
                    'filtro' => "[A-Za-z0-9]{6,15}",
                    'cadena' => $funcionario['numero_documento']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $funcionario['nombres']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $funcionario['apellidos']
                ],
                [
                    'filtro' => "[0-9]{10}",
                    'cadena' => $funcionario['telefono']
                ],
                [
                    'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                    'cadena' => $funcionario['correo_electronico']
                ],
                [
                    'filtro' => "(PLANTA|CONTRATISTA)",
                    'cadena' => $funcionario['tipo_contrato']
                ],
                [
                    'filtro' => "(SI|NO)",
                    'cadena' => $funcionario['brigadista']
                ],
                [
                    'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TÉCNICO|PERSONAL ASEO)',
                    'cadena' => $funcionario['rol']
                ]
            ];

            if($funcionario['tipo_contrato'] == 'CONTRATISTA'){
                if(!isset($funcionario['fecha_fin_contrato']) || $funcionario['fecha_fin_contrato'] == ''){
                    $respuesta = [
                        "tipo" => "ERROR",
                        "titulo" => 'Campos Obligatorios',
                        "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                    ];
                    return $respuesta;
                }

                $datos[] = [
                    'filtro' => '(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-[0-9]{4}',
                    'cadena' => $funcionario['fecha_fin_contrato']
                ];
            }

            $funcionario['estado_usuario'] = 'NULL';
            if($funcionario['rol'] == 'COORDINADOR' || $funcionario['rol'] == 'INSTRUCTOR'){
                if(!isset($funcionario['contrasena']) || $funcionario['contrasena'] == ''){
                    $respuesta = [
                        "tipo" => "ERROR",
                        "titulo" => 'Campos Obligatorios',
                        "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
                    ];
                    return $respuesta;
                }

                $funcionario['estado_usuario'] = "'ACTIVO'";

                $datos[] = [
                    'filtro' => '[A-Za-z0-9*_@\-]{8,}',
                    'cadena' => $funcionario['contrasena']
                ];
            }
            
            foreach ($datos as $dato) {
                if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
                    $respuesta = [
                        "tipo" => "ERROR",
                        'titulo' => "Formato Inválido",
                        'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                    ];
                    return $respuesta;
                }
            }

            $funcionario['nombres'] = mb_convert_case(mb_strtolower($funcionario['nombres'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $funcionario['apellidos'] = mb_convert_case(mb_strtolower($funcionario['apellidos'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $funcionario['correo_electronico'] = mb_strtolower($funcionario['correo_electronico'], "UTF-8");
            $contrasena = $funcionario['contrasena'] != '' ? md5($funcionario['contrasena']) : 'NULL';
            $funcionario['contrasena'] = $contrasena != 'NULL' ? "'$contrasena'" : $contrasena;
            
            $fechaFinContrato = 'NULL';
            if($funcionario['fecha_fin_contrato'] != ''){
                $fechaFinContrato = explode('-', $funcionario['fecha_fin_contrato']);
                $fechaFinContrato = $fechaFinContrato[2] . '-'. $fechaFinContrato[1] . '-' . $fechaFinContrato[0];                
            }
            $funcionario['fecha_fin_contrato'] = $fechaFinContrato != 'NULL' ? "'$fechaFinContrato'" : $fechaFinContrato;
        }
        unset($funcionario);

        $respuesta = [
            "tipo" => "OK",
            "datos_funcionarios" => $funcionarios
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
                'filtro' => '(INSTRUCTOR|COORDINADOR|PERSONAL ADMINISTRATIVO|SOPORTE TÉCNICO|PERSONAL ASEO)',
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

        if($rol == 'COORDINADOR' || $rol == 'INSTRUCTOR'){
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
                'filtro' => '|[A-Za-z0-9*_@\-]{8,}',
                'cadena' => $contrasena
            ];
        }
		
        foreach ($datos as $dato) {
			if(!preg_match("/^".$dato['filtro']."$/", $dato['cadena'])){
				$respuesta = [
                    "tipo" => "ERROR",
                    'titulo' => "Formato Inválido",
                    'mensaje' => "Lo sentimos, los datos no cumplen con la estructura requerida.",
                ];
                return $respuesta;
			}
        }

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");
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

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['rol'])){
            $rol = $this->limpiarDatos($_GET['rol']);
            unset($_GET['rol']);

            if(preg_match('/^(COORDINADOR|INSTRUCTOR|PERSONAL ADMINISTRATIVO|PERSONAL ASEO|SOPORTE TÉCNICO|SUBDIRECTOR)$/', $rol)){
                $parametros['rol'] = $rol;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }
}
    

