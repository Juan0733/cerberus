<?php
namespace App\Services;

class AprendizService extends MainService{
    public function sanitizarDatosRegistroAprendizIndividual(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['numero_ficha'] == '' || $_POST['nombre_programa'] == '' || $_POST['fecha_fin_ficha'] == ''){
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
        $numeroFicha = $this->limpiarDatos($_POST['numero_ficha']);
        $nombrePrograma = $this->limpiarDatos($_POST['nombre_programa']);
        $fechaFinFicha = $this->limpiarDatos($_POST['fecha_fin_ficha']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']); 
		
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
                'filtro' => "[0-9]{7}",
                'cadena' => $numeroFicha
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
                'cadena' => $nombrePrograma
            ],
            [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinFicha
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

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");
        $nombrePrograma = mb_convert_case(mb_strtolower($nombrePrograma, "UTF-8"), MB_CASE_TITLE, "UTF-8");

        $datosAprendiz = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'numero_ficha' => $numeroFicha,
            'nombre_programa' => $nombrePrograma,
            'fecha_fin_ficha' => $fechaFinFicha
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_aprendiz" => $datosAprendiz
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroAprendizCargaMasiva(){
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
        $encabezados = ['tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'telefono', 'correo_electronico', 'numero_ficha', 'nombre_programa', 'fecha_fin_ficha'];
        $columnaLimite = 'I';

        $respuesta = $this->leerArchivoExcel($rutaArchivo, $encabezados, $columnaLimite);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $aprendices = $respuesta['datos_excel'];

        if(count($aprendices) < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Lo sentimos, pero parece que el archivo excel se encuentra vacío o no esta diligenciado correctamente.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadDatosArray($aprendices, 'numero_documento');
        if($respuesta['tipo'] == 'ERROR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Duplicidad Datos Excel',
                'mensaje' => 'Lo sentimos, pero en el archivo excel se encontraron números de documento duplicados.'
            ];
            return $respuesta;
        }

        foreach ($aprendices as &$aprendiz) {
            $datos = [
                [
                    'filtro' => "[A-Z]{2,3}",
                    'cadena' => $aprendiz['tipo_documento']
                ],
                [
                    'filtro' => "[A-Za-z0-9]{6,15}",
                    'cadena' => $aprendiz['numero_documento']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $aprendiz['nombres']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $aprendiz['apellidos']
                ],
                [
                    'filtro' => "[0-9]{10}",
                    'cadena' => $aprendiz['telefono']
                ],
                [
                    'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                    'cadena' => $aprendiz['correo_electronico']
                ],
                [
                    'filtro' => "[0-9]{7}",
                    'cadena' => $aprendiz['numero_ficha']
                ],
                [
                    'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
                    'cadena' => $aprendiz['nombre_programa']
                ],
                [
                    'filtro' => '(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-[0-9]{4}',
                    'cadena' => $aprendiz['fecha_fin_ficha']
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

            $aprendiz['nombres'] = mb_convert_case(mb_strtolower($aprendiz['nombres'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $aprendiz['apellidos'] = mb_convert_case(mb_strtolower($aprendiz['apellidos'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            $aprendiz['correo_electronico'] = mb_strtolower($aprendiz['correo_electronico'], "UTF-8");
            $aprendiz['nombre_programa'] = mb_convert_case(mb_strtolower($aprendiz['nombre_programa'], "UTF-8"), MB_CASE_TITLE, "UTF-8");
            
            $fechaFinFicha = explode('-', $aprendiz['fecha_fin_ficha']);
            $aprendiz['fecha_fin_ficha'] = $fechaFinFicha[2] . '-' . $fechaFinFicha[1] . '-' . $fechaFinFicha[0];
        }
        unset($aprendiz);

        $respuesta = [
            "tipo" => "OK",
            "datos_aprendices" => $aprendices
        ];
        return $respuesta; 
    }

    public function sanitizarDatosActualizacionAprendiz(){
        if(!isset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']) || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['numero_documento'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['numero_ficha'] == '' || $_POST['nombre_programa'] == '' || $_POST['fecha_fin_ficha'] == ''){
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
        $numeroFicha = $this->limpiarDatos($_POST['numero_ficha']);
        $nombrePrograma = $this->limpiarDatos($_POST['nombre_programa']);
        $fechaFinFicha = $this->limpiarDatos($_POST['fecha_fin_ficha']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['numero_ficha'], $_POST['nombre_programa'], $_POST['fecha_fin_ficha']); 
		
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
                'filtro' => "[0-9]{7}",
                'cadena' => $numeroFicha
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}",
                'cadena' => $nombrePrograma
            ],
            [
                'filtro' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])',
                'cadena' => $fechaFinFicha
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

        $nombres = mb_convert_case(mb_strtolower($nombres, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $apellidos = mb_convert_case(mb_strtolower($apellidos, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $correoElectronico = mb_strtolower($correoElectronico, "UTF-8");
        $nombrePrograma = mb_convert_case(mb_strtolower($nombrePrograma, "UTF-8"), MB_CASE_TITLE, "UTF-8");

        $datosAprendiz = [
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'numero_ficha' => $numeroFicha,
            'nombre_programa' => $nombrePrograma,
            'fecha_fin_ficha' => $fechaFinFicha
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_aprendiz" => $datosAprendiz
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

        if(isset($_GET['ficha'])){
            $numeroFicha = $this->limpiarDatos($_GET['ficha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]{4,7}$/', $numeroFicha)){
                $parametros['numero_ficha'] = $numeroFicha;
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
    