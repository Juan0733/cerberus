<?php
namespace App\Services;

class VigilanteService extends MainService{

    public function sanitizarDatosRegistroVigilanteIndividual(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol'], $_POST['contrasena']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['rol'] == '' || $_POST['contrasena'] == ''){
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
        $rol = $this->limpiarDatos($_POST['rol']);
        $contrasena = $this->limpiarDatos($_POST['contrasena']);
        
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol'], $_POST['contrasena']); 
		
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
                'filtro' => "(VIGILANTE|SUPERVISOR)",
                'cadena' => $rol
            ],
            [
                'filtro' => "[A-Za-z0-9*_@\-]{8,}",
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

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");
        $contrasena = md5($contrasena);
        $estadoUsuario = 'ACTIVO';

        $datosVigilante = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'rol' => $rol,
            'contrasena' => $contrasena,
            'estado_usuario' => $estadoUsuario
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_vigilante" => $datosVigilante
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroVigilanteCargaMasiva(){
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
        $encabezados = ['tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'telefono', 'correo_electronico', 'rol', 'contrasena'];
        $columnaLimite = 'H';

        $respuesta = $this->leerArchivoExcel($rutaArchivo, $encabezados, $columnaLimite);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $vigilantes = $respuesta['datos_excel'];

        if(count($vigilantes) < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Lo sentimos, pero parece que el archivo excel se encuentra vacío o no esta diligenciado correctamente.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadDatosArray($vigilantes, 'numero_documento');
        if($respuesta['tipo'] == 'ERROR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Duplicidad Datos Excel',
                'mensaje' => 'Lo sentimos, pero en el archivo excel se encontraron números de documento duplicados.'
            ];
            return $respuesta;
        }

        foreach ($vigilantes as &$vigilante) {
            $datos = [
                [
                    'filtro' => "[A-Z]{2,3}",
                    'cadena' => $vigilante['tipo_documento']
                ],
                [
                    'filtro' => "[A-Za-z0-9]{6,15}",
                    'cadena' => $vigilante['numero_documento']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $vigilante['nombres']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $vigilante['apellidos']
                ],
                [
                    'filtro' => "[0-9]{10}",
                    'cadena' => $vigilante['telefono']
                ],
                [
                    'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                    'cadena' => $vigilante['correo_electronico']
                ],
                [
                    'filtro' => "(VIGILANTE|SUPERVISOR)",
                    'cadena' => $vigilante['rol']
                ],
                [
                    'filtro' => "[A-Za-z0-9*_@\-]{8,}",
                    'cadena' => $vigilante['contrasena']
                ]
            ];
            
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

            $vigilante['nombres'] = mb_convert_case(mb_strtolower($vigilante['nombres'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $vigilante['apellidos'] = mb_convert_case(mb_strtolower($vigilante['apellidos'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $vigilante['correo_electronico'] = mb_strtolower($vigilante['correo_electronico'], "UTF-8");
            $vigilante['contrasena'] = md5($vigilante['contrasena']);
            $vigilante['estado_usuario'] = 'ACTIVO';
        }
        unset($vigilante);

        $respuesta = [
            "tipo" => "OK",
            "datos_vigilantes" => $vigilantes
        ];
        return $respuesta;
    }

    public function sanitizarDatosActualizacionVigilante(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol'], $_POST['contrasena']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['rol'] == ''){
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
        $rol = $this->limpiarDatos($_POST['rol']);
        $contrasena = $this->limpiarDatos($_POST['contrasena']);
        
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['documento_visitante'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol'], $_POST['contrasena']); 
		
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
                'filtro' => "(VIGILANTE|SUPERVISOR)",
                'cadena' => $rol
            ],
            [
                'filtro' => "|[A-Za-z0-9*_@\-]{8,}",
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

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");

        $datosVigilante = [
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'rol' => $rol
        ];

        if(!empty($contrasena)){
            $datosVigilante['contrasena'] = md5($contrasena);
        }

        $respuesta = [
            "tipo" => "OK",
            "datos_vigilante" => $datosVigilante
        ];
        return $respuesta;
    }

     public function sanitizarDatosPuerta(){
        if(!isset($_POST['puerta']) || $_POST['puerta'] == '' ){
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje"=> 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

        $puerta = $this->limpiarDatos($_POST['puerta']);
        unset($_POST['puerta']); 
		
		$datos = [
            [
				'filtro' => "PRINCIPAL|PEATONAL|GANADERIA",
				'cadena' => $puerta
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

        $respuesta = [
            "tipo" => "OK",
            "puerta" => $puerta
        ];
        return $respuesta;
    }

    public function sanitizarParametros()
    {
        $parametros = [];

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

            if(preg_match('/^(VIGILANTE|SUPERVISOR)$/', $rol)){
                $parametros['rol'] = $rol;
            }
        }

        if(isset($_GET['cantidad'])){
            $cantidadRegistros = $this->limpiarDatos($_GET['cantidad']);
            unset($_GET['cantidad']);

            if(preg_match('/^(5|10)$/', $cantidadRegistros)){
                $parametros['cantidad_registros'] = $cantidadRegistros;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }    
}