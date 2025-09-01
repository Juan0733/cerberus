<?php
namespace App\Services;

class VigilanteService{

    public function sanitizarDatosRegistroVigilante(){
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

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
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

    public function sanitizarDatosAutoRegistroVigilante(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['rol'] == ''){
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
        
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['rol']); 
		
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

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $contrasena = 'NULL';
        $estadoUsuario = 'INACTIVO';

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

        $nombres = mb_convert_case(mb_strtolower(trim($nombres), "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower(trim($apellidos), "UTF-8"), MB_CASE_TITLE, "UTF-8");

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

    public function sanitizarDatosHabilitacionVigilante(){
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

        $datosVigilante = [
            'numero_documento' => $numeroDocumento,
            'contrasena' => $contrasena
        ];

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

            if(preg_match('/^[A-Za-z0-9]{1,15}$/', $numeroDocumento)){
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