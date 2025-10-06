<?php
namespace App\Services;

class AgendaService extends MainService{

    public function sanitizarDatosActualizacionAgenda(){
        if (!isset($_POST['codigo_agenda'], $_POST['motivo'], $_POST['titulo'], $_POST['fecha_agenda']) || $_POST['codigo_agenda'] == '' || $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
            return $respuesta;
        }

       
        $codigoAgenda = $this->limpiarDatos($_POST['codigo_agenda']);
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_POST['codigo_agenda'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']);

        $datos = [
            [
                'filtro' => "[A-Z0-9]{16}",
                'cadena' => $codigoAgenda
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $titulo = mb_convert_case(mb_strtolower($titulo, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $motivo = mb_strtoupper(mb_substr($motivo, 0, 1, "UTF-8"), "UTF-8").mb_strtolower(mb_substr($motivo, 1, null, "UTF-8"), "UTF-8");

        $datosAgenda = [
            'codigo_agenda' => $codigoAgenda,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroAgendaIndividual(){
        if (!isset($_POST['tipo_documento'], $_POST['numero_documento'], $_POST['nombres'], $_POST['apellidos'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']) || $_POST['tipo_documento'] == '' || $_POST['numero_documento'] == '' || $_POST['nombres'] == '' || $_POST['apellidos'] == '' || $_POST['telefono'] == '' || $_POST['correo_electronico'] == '' || $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $tipoDocumento = $this->limpiarDatos($_POST['tipo_documento']);
        $numeroDocumento = $this->limpiarDatos($_POST['numero_documento']);
        $nombres = $this->limpiarDatos($_POST['nombres']);
        $apellidos = $this->limpiarDatos($_POST['apellidos']);
        $telefono = $this->limpiarDatos($_POST['telefono']);
        $correoElectronico = $this->limpiarDatos($_POST['correo_electronico']);
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_POST['nombres'], $_POST['apellidos'], $_POST['tipo_documento'], $_POST['numero_documento'], $_POST['telefono'], $_POST['correo_electronico'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']); 
		
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
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $titulo = mb_convert_case(mb_strtolower($titulo, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $motivo = mb_strtoupper(mb_substr($motivo, 0, 1, "UTF-8"), "UTF-8").mb_strtolower(mb_substr($motivo, 1, null, "UTF-8"), "UTF-8");

        $datosAgenda = [
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'correo_electronico' => $correoElectronico,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta;
    }

    public function sanitizarDatosRegistroAgendaCargaMasiva(){
        if (!isset($_FILES['plantilla_excel'],  $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']) || $_FILES['plantilla_excel'] == '' ||  $_POST['titulo'] == '' || $_POST['motivo'] == '' || $_POST['fecha_agenda'] == '') {
            $respuesta = [
                "tipo" => "ERROR",
                "titulo" => 'Campos Obligatorios',
                "mensaje" => 'Lo sentimos, es necesario que ingreses todos los datos que son obligatorios.'
            ];
          return $respuesta;
        }

        $archivo = $_FILES['plantilla_excel'];
        $titulo = $this->limpiarDatos($_POST['titulo']);
        $motivo = $this->limpiarDatos($_POST['motivo']);
        $fechaAgenda = $this->limpiarDatos($_POST['fecha_agenda']);
        unset($_FILES['plantilla_excel'], $_POST['titulo'], $_POST['motivo'], $_POST['fecha_agenda']); 

        $datos = [
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}",
                'cadena' => $titulo
            ],
            [
                'filtro' => "[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9., ]{5,150}",
                'cadena' => $motivo
            ],
            [
                'filtro' => "[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])",
                'cadena' => $fechaAgenda
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

        $respuesta = $this->guardarArhivoExcel($archivo);
        if($respuesta == 'ERROR'){
            return $respuesta;
        }

        $rutaArchivo = $respuesta['ruta_archivo'];
        $encabezados = ['tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'telefono', 'correo_electronico'];
        $columnaLimite = 'F';

        $respuesta = $this->leerArchivoExcel($rutaArchivo, $encabezados, $columnaLimite);
        if($respuesta['tipo'] == 'ERROR'){
            return $respuesta;
        }
        $agendados = $respuesta['datos_excel'];

        if(count($agendados) < 1){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Error Excel',
                'mensaje' => 'Lo sentimos, pero parece que el archivo excel se encuentra vacío o no esta diligenciado correctamente.'
            ];
            return $respuesta;
        }

        $respuesta = $this->validarDuplicidadDatosArray($agendados, 'numero_documento');
        if($respuesta['tipo'] == 'ERROR'){
            $respuesta = [
                'tipo' => 'ERROR',
                'titulo' => 'Duplicidad Datos Excel',
                'mensaje' => 'Lo sentimos, pero en el archivo excel se encontraron números de documento duplicados.'
            ];
            return $respuesta;
        }

        foreach ($agendados as $agendado) {
            $datos = [
                [
                    'filtro' => "[A-Z]{2,3}",
                    'cadena' => $agendado['tipo_documento']
                ],
                [
                    'filtro' => "[A-Za-z0-9]{6,15}",
                    'cadena' => $agendado['numero_documento']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $agendado['nombres']
                ],
                [
                    'filtro' => "[A-Za-z ]{2,50}",
                    'cadena' => $agendado['apellidos']
                ],
                [
                    'filtro' => "[0-9]{10}",
                    'cadena' => $agendado['telefono']
                ],
                [
                    'filtro' => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}",
                    'cadena' => $agendado['correo_electronico']
                ],
            
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
        }

        $titulo = mb_convert_case(mb_strtolower($titulo, "UTF-8"), MB_CASE_TITLE, "UTF-8");
        $motivo = mb_strtoupper(mb_substr($motivo, 0, 1, "UTF-8"), "UTF-8").mb_strtolower(mb_substr($motivo, 1, null, "UTF-8"), "UTF-8");

        $datosAgenda = [
            'agendados' => $agendados,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha_agenda' => $fechaAgenda
        ];

        $respuesta = [
            "tipo" => "OK",
            "datos_agenda" => $datosAgenda
        ];
        return $respuesta; 
    }

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['codigo_agenda'])){
            $codigoAgenda = $this->limpiarDatos($_GET['codigo_agenda']);
            unset($_GET['codigo_agenda']);

            if(preg_match('/^[A-Z0-9]{16}$/', $codigoAgenda)){
                $parametros['codigo_agenda'] = $codigoAgenda;
            }
        }

        if(isset($_GET['fecha'])){
            $fecha = $this->limpiarDatos($_GET['fecha']);
            unset($_GET['fecha']);

            if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $fecha)){
                $parametros['fecha'] = $fecha;
            }
        }

        if(isset($_GET['documento'])){
            $numeroDocumento = $this->limpiarDatos($_GET['documento']);
            unset($_GET['documento']);

            if(preg_match('/^[A-Za-z0-9]{6,15}$/', $numeroDocumento)){
                $parametros['numero_documento'] = $numeroDocumento;
            }
        }

        if(isset($_GET['titulo'])){
            $titulo = $this->limpiarDatos($_GET['titulo']);
            unset($_GET['titulo']);

            if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}$/', $titulo)){
                $parametros['titulo'] = $titulo;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }
}
    